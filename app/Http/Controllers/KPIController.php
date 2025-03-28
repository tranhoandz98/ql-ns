<?php

namespace App\Http\Controllers;

use App\Enums\DayOff\StatusDayOffEnum;
use App\Enums\DayOff\TypeDayOffEnum;
use App\Enums\DayOff\TypeSessionDayOffEnum;
use App\Enums\StatusApproveEnum;
use App\Enums\User\ColorEnum;
use App\Enums\User\StatusNotifyReadEnum;
use App\Enums\User\TypeGroupEnum;
use App\Enums\User\TypeGroupExpectedStartEnum;
use App\Enums\User\TypeNotifyReadEnum;
use App\Enums\User\TypeOvertimeEnum;
use App\Enums\User\TypeUserEnum;
use App\Http\Requests\KPIRequest;
use App\Models\Notifications;
use App\Models\KPI;
use App\Models\DayOffsUser;
use App\Models\KPIDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class KPIController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $groupBy = $request->group_by;

        $query = KPI::with([
            'user:id,code,name'
        ])
            ->where(function ($query) use ($request) {
                if (!empty($request->name)) {
                    // $query->where('code', 'like', '%' . $request->name . '%');
                    $query->orWhere('code',  $request->name);
                }
                if (!empty($request->status)) {
                    $query->where('status', $request->status);
                }
                if (!empty($request->user_id)) {
                    $query->where('user_id', $request->user_id);
                }
                if (!empty($request->start_at)) {
                    $dates = explode(' to ', $request->start_at);
                    if (count($dates) === 2) {
                        $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                        $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                        $query->whereBetween('start_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
                    }
                }
                // Check user type and filter records accordingly
                $user = Auth::user();
                if ($user) {
                    if ($user->type === TypeUserEnum::NHAN_VIEN->value) {
                        // For regular employees, only show their own records
                        $query->where('user_id', $user->id);
                    } elseif ($user->type === TypeUserEnum::CAN_BO_QUAN_LY->value) {
                        // For managers, show records of users they manage
                        $query->whereHas('user', function ($q) use ($user) {
                            $q->where('manager_id', $user->id);
                        });
                    }
                    // Admin can see all records, so no additional filter needed
                }
            });

        $listAll = $query;
        if (!empty($groupBy)) {
            // Define the grouping format based on the input
            $groupFormat = match ($groupBy) {
                TypeGroupExpectedStartEnum::MONTH->value => '%Y-%m',
                TypeGroupExpectedStartEnum::YEAR->value => '%Y',
                default => '%Y-%m' // Default to monthly grouping
            };

            $listAll = $query->select([
                'user_id',
                DB::raw("DATE_FORMAT(start_at, '$groupFormat') as group_period"),
                DB::raw('COUNT(id) as total_records'),
                DB::raw('SUM(num) as total_num'),
                DB::raw('MIN(start_at) as first_start_at'),
            ])
                ->groupBy('user_id', 'group_period')
                ->orderBy('group_period', 'desc')
                ->get()
                ->map(function ($parent) use ($groupFormat, $request) {
                    // Get child records for each group
                    $parent->records = KPI::where('user_id', $parent->user_id)
                        ->whereRaw("DATE_FORMAT(start_at, '$groupFormat') = ?", [$parent->group_period])
                        ->where(function ($query) use ($request) {
                            if (!empty($request->start_at)) {
                                $dates = explode(' to ', $request->start_at);
                                if (count($dates) === 2) {
                                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                                    $query->whereBetween('start_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
                                }
                            }
                        })
                        ->orderBy('start_at', 'asc')
                        ->get([
                            'id',
                            'start_at',
                            'end_at',
                            'num',
                            'code',
                            'user_id',
                            'status',
                            'created_at'
                        ]);
                    return $parent;
                });
        } else {
            $listAll = $query->orderBy('start_at', 'desc')
                // ->get()
                ->paginate($perPage);
        }

        $users = User::select(['id', 'name', 'code'])->active()->get();

        $statusApproveEnum = StatusApproveEnum::options();
        $typeGroupEnum = TypeGroupEnum::options();

        return view('pages.kpi.index', compact(
            'listAll',
            'users',
            'statusApproveEnum',
            'typeGroupEnum'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select(['id', 'name', 'code'])->active()->get();

        return view(
            'pages.kpi.create',
            compact(
                'users',
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KPIRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = KPI::create(
                [
                    'code'=> $this->genderEnumCode(),
                    'name' => $request->name,
                    'user_id' => $request->user_id,
                    'start_at' => Carbon::createFromFormat('d/m/Y', $request->start_at)->format('Y-m-d'),
                    'end_at' => Carbon::createFromFormat('d/m/Y', $request->end_at)->format('Y-m-d'),
                    'note' => $request->note,
                    'description' => $request->description,
                    'num' => $request->num,
                    'status'=> StatusApproveEnum::DRAFT
                ]
            );

            foreach ($request->items as $item) {
                KPIDetail::create([
                    'kpi_id' => $result->id,
                    'title' => $item['title'],
                    'ratio' => $item['ratio'],
                    'staff_evaluation' => $item['staff_evaluation'],
                    'assessment_manager' => $item['assessment_manager'],
                    'target' => $item['target'],
                    'manager_note' => $item['manager_note'],
                ]);
            }
            DB::commit();
            return redirect()->route('kpi.index')
                ->with(
                    ['message' => Lang::get('messages.kpi-create_s'), 'status' => 'success']
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $result = KPI::with(
            [
                'createdByData:id,name',
                'updatedByData:id,name',
                'details'
            ]
        )->find($id);

        $users = User::select(['id', 'name', 'code'])->active()->get();
        $statusApproveEnum = StatusApproveEnum::options();

        return view('pages.kpi.show', compact(
            'result',
            'users',
            'statusApproveEnum',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        $result = KPI::with(
            [
                'details'
            ]
        )->find($id);
        $users = User::select(['id', 'name', 'code'])->active()->get();

        return view('pages.kpi.edit', compact(
            'result',
            'users',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KPIRequest $request, string $id)
    {

        DB::beginTransaction();
        try {
            $result = KPI::findOrFail($id);

            $result->update(
                [
                    'name' => $request->name,
                    'user_id' => $request->user_id,
                    'start_at' => Carbon::createFromFormat('d/m/Y', $request->start_at)->format('Y-m-d'),
                    'end_at' => Carbon::createFromFormat('d/m/Y', $request->end_at)->format('Y-m-d'),
                    'note' => $request->note,
                    'description' => $request->description,
                    'num' => $request->num,
                    'status'=> StatusApproveEnum::DRAFT
                ]
            );

            KPIDetail::where('kpi_id', $result->id)->delete();
            foreach ($request->items as $item) {
                KPIDetail::create([
                    'kpi_id' => $result->id,
                    'title' => $item['title'],
                    'ratio' => $item['ratio'],
                    'staff_evaluation' => $item['staff_evaluation'],
                    'assessment_manager' => $item['assessment_manager'],
                    'target' => $item['target'],
                    'manager_note' => $item['manager_note'],
                ]);
            }
            DB::commit();
            return redirect()->route('kpi.index')
                ->with(
                    ['message' => Lang::get('messages.kpi-update_s'), 'status' => 'success']
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $record = KPI::find($id);
        $record->delete();
        return redirect()->route('kpi.index')
            ->with(
                ['message' => Lang::get('messages.kpi-delete_s'), 'status' => 'success']
            );
    }

    public function genderEnumCode()
    {
        return 'KPI' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Send kpi request for approval and notify manager
     */
    public function send(string $id)
    {
        DB::beginTransaction();
        try {
            $kpi = KPI::findOrFail($id);

            // Update status to waiting for manager approval
            $kpi->update([
                'status' => StatusDayOffEnum::WAIT_MANAGER,
            ]);

            // Get the manager of the user who created the kpi request
            $manager = User::find($kpi->user->manager_id);
            if ($manager) {
                // Create notification record for the manager
                Notifications::create([
                    'user_id' => $manager->id,
                    'title' => 'Yêu cầu KPI',
                    'content' => 'Bạn có một yêu cầu KPI cần duyệt từ ' . $kpi->user->name . ' (Mã: ' . $kpi->code . ')',
                    'link' => route('kpi.show', $kpi->id),
                    'is_read' => StatusNotifyReadEnum::UNREAD,
                    'type' => TypeNotifyReadEnum::KPI,
                    'color' => ColorEnum::WARNING
                ]);

                $manager->update([
                    'unread_notification' => $manager->unread_notification ? $manager->unread_notification + 1 : 1
                ]);
            }

            DB::commit();
            return redirect()->route('kpi.index')
                ->with([
                    'message' => Lang::get('messages.kpi-send_s'),
                    'status' => 'success'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function approve(string $id)
    {
        DB::beginTransaction();
        try {
            $kpi = KPI::findOrFail($id);

            $kpi->update([
                'status' => StatusDayOffEnum::DONE,
            ]);

            $user = User::find($kpi->created_by);
            if ($user) {
                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'Yêu cầu KPI đã được duyệt',
                    'content' => 'Yêu cầu KPI của bạn đã được duyệt (Mã: ' . $kpi->code . ')',
                    'link' => route('kpi.show', $kpi->id),
                    'is_read' => StatusNotifyReadEnum::UNREAD,
                    'type' => TypeNotifyReadEnum::KPI,
                    'color' => ColorEnum::SUCCESS
                ]);

                $user->update([
                    'unread_notification' => $user->unread_notification ? $user->unread_notification + 1 : 1
                ]);
            }

            DB::commit();
            return redirect()->route('kpi.index')
                ->with([
                    'message' => Lang::get('messages.kpi-approve_s'),
                    'status' => 'success'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Reject kpi request and notify the requester
     */
    public function reject(string $id)
    {
        DB::beginTransaction();
        try {
            $kpi = KPI::findOrFail($id);

            $kpi->update([
                'status' => StatusDayOffEnum::REJECT,
            ]);

            $user = User::find($kpi->created_by);
            if ($user) {
                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'Yêu cầu KPI đã bị từ chối',
                    'content' => 'Yêu cầu KPI của bạn đã bị từ chối (Mã: ' . $kpi->code . ')',
                    'link' => route('kpi.show', $kpi->id),
                    'is_read' => StatusNotifyReadEnum::UNREAD,
                    'type' => TypeNotifyReadEnum::KPI,
                    'color' => ColorEnum::DANGER
                ]);

                $user->update([
                    'unread_notification' => $user->unread_notification ? $user->unread_notification + 1 : 1
                ]);
            }

            DB::commit();
            return redirect()->route('kpi.index')
                ->with([
                    'message' => Lang::get('messages.kpi-reject_s'),
                    'status' => 'success'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
