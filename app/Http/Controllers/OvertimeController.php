<?php

namespace App\Http\Controllers;

use App\Enums\User\ColorEnum;
use App\Enums\User\StatusNotifyReadEnum;
use App\Enums\User\StatusOverTimeEnum;
use App\Enums\User\TypeGroupExpectedStartEnum;
use App\Enums\User\TypeNotifyReadEnum;
use App\Enums\User\TypeOvertimeEnum;
use App\Enums\User\TypeUserEnum;
use App\Http\Requests\OvertimeRequest;
use App\Models\Notifications;
use App\Models\Overtimes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class OvertimeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $groupBy = $request->group_by;

        $query = Overtimes::with([
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
                if (!empty($request->expected_start)) {
                    $dates = explode(' to ', $request->expected_start);
                    if (count($dates) === 2) {
                        $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                        $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                        $query->whereBetween('expected_start', [$startDate->startOfDay(), $endDate->endOfDay()]);
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
                DB::raw("DATE_FORMAT(expected_start, '$groupFormat') as group_period"),
                DB::raw('COUNT(id) as total_records'),
                DB::raw('SUM(expected_time) as total_expected_time'),
                DB::raw('SUM(actual_time) as total_actual_time'),
                DB::raw('MIN(expected_start) as first_expected_start'),
                DB::raw('MAX(expected_end) as last_expected_end')
            ])
                ->groupBy('user_id', 'group_period')
                ->orderBy('group_period', 'desc')
                ->get()
                ->map(function ($parent) use ($groupFormat, $request) {
                    // Get child records for each group
                    $parent->records = Overtimes::where('user_id', $parent->user_id)
                        ->whereRaw("DATE_FORMAT(expected_start, '$groupFormat') = ?", [$parent->group_period])
                        ->where(function ($query) use ($request) {
                            if (!empty($request->expected_start)) {
                                $dates = explode(' to ', $request->expected_start);
                                if (count($dates) === 2) {
                                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                                    $query->whereBetween('expected_start', [$startDate->startOfDay(), $endDate->endOfDay()]);
                                }
                            }
                        })
                        ->orderBy('expected_start', 'asc')
                        ->get([
                            'id',
                            'expected_start',
                            'expected_end',
                            'expected_time',
                            'actual_time',
                            'code',
                            'user_id',
                            'type',
                            'content',
                            'status',
                            'created_at'
                        ]);
                    return $parent;
                });
        } else {
            $listAll = $query->orderBy('expected_start', 'desc')
                // ->get()
                ->paginate($perPage);
        }

        $users = User::select(['id', 'name', 'code'])->active()->get();
        $statusOverTimeEnum = StatusOverTimeEnum::options();
        $typeOvertimeEnum = TypeOvertimeEnum::options();
        $typeGroupExpectedStartEnum = TypeGroupExpectedStartEnum::options();

        return view('pages.overtimes.index', compact(
            'listAll',
            'users',
            'statusOverTimeEnum',
            'typeOvertimeEnum',
            'typeGroupExpectedStartEnum'

        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select(['id', 'name', 'code'])->active()->get();
        $typeOvertimeEnum = TypeOvertimeEnum::options();
        return view(
            'pages.overtimes.create',
            compact(
                'users',
                'typeOvertimeEnum'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OvertimeRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $result = Overtimes::create([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'code' => $this->genderEnumCode(),

                'content' => $request->content,
                'work_results' => $request->work_results,
                'note' => $request->note,

                'expected_start' => Carbon::createFromFormat('d/m/Y H:i', $request->expected_start)->format('Y-m-d H:i:s'),
                'expected_end' => Carbon::createFromFormat('d/m/Y H:i', $request->expected_end)->format('Y-m-d H:i:s'),
                'actual_start' => !empty($request->actual_start) ? Carbon::createFromFormat('d/m/Y H:i', $request->actual_start)->format('Y-m-d H:i:s') : null,
                'actual_end' => !empty($request->actual_end) ?  Carbon::createFromFormat('d/m/Y H:i', $request->actual_end)->format('Y-m-d H:i:s') : null,

                'expected_time' => $request->expected_time,
                'actual_time' => $request->actual_time,
                'status' => StatusOverTimeEnum::DRAFT,
            ]);
            DB::commit();

            return redirect()->route('overtimes.index')
                ->with(
                    ['message' => Lang::get('messages.overtime-create_s'), 'status' => 'success']
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
        $result = Overtimes::with(
            [
                'createdByData:id,name',
                'updatedByData:id,name',
            ]
        )->find($id);
        $typeOvertimeEnum = TypeOvertimeEnum::options();
        $users = User::select(['id', 'name', 'code'])->active()->get();
        $statusOverTimeEnum = StatusOverTimeEnum::options();

        return view('pages.overtimes.show', compact(
            'result',
            'users',
            'typeOvertimeEnum',
            'statusOverTimeEnum'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        $result = Overtimes::with(
            []
        )->find($id);
        $users = User::select(['id', 'name', 'code'])->active()->get();
        $typeOvertimeEnum = TypeOvertimeEnum::options();

        return view('pages.overtimes.edit', compact(
            'result',
            'users',
            'typeOvertimeEnum'

        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OvertimeRequest $request, string $id)
    {

        DB::beginTransaction();
        try {
            $result = Overtimes::findOrFail($id);
            $result->update([
                'type' => $request->type,

                'content' => $request->content,
                'work_results' => $request->work_results,
                'note' => $request->note,

                'actual_start' => !empty($request->actual_start) ? Carbon::createFromFormat('d/m/Y H:i', $request->actual_start)->format('Y-m-d H:i:s') : null,
                'actual_end' => !empty($request->actual_end) ?  Carbon::createFromFormat('d/m/Y H:i', $request->actual_end)->format('Y-m-d H:i:s') : null,

                'actual_time' => $request->actual_time,
                'status' => StatusOverTimeEnum::DRAFT,
            ]);
            DB::commit();
            return redirect()->route('overtimes.index')
                ->with(
                    ['message' => Lang::get('messages.overtime-update_s'), 'status' => 'success']
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
        $record = Overtimes::find($id);
        $record->delete();
        return redirect()->route('overtimes.index')
            ->with(
                ['message' => Lang::get('messages.overtime-delete_s'), 'status' => 'success']
            );
    }

    public function genderEnumCode()
    {
        return 'OT' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Send overtime request for approval and notify manager
     */
    public function send(string $id)
    {
        DB::beginTransaction();
        try {
            $overtime = Overtimes::findOrFail($id);

            // Update status to waiting for manager approval
            $overtime->update([
                'status' => StatusOverTimeEnum::WAIT_MANAGER,
            ]);

            // Get the manager of the user who created the overtime request
            $manager = User::find($overtime->user->manager_id);
            if ($manager) {
                // Create notification record for the manager
                Notifications::create([
                    'user_id' => $manager->id,
                    'title' => 'Yêu cầu tăng ca mới',
                    'content' => 'Bạn có một yêu cầu tăng ca mới cần duyệt từ ' . $overtime->user->name . ' (Mã: ' . $overtime->code . ')',
                    'link' => route('overtimes.show', $overtime->id),
                    'is_read' => StatusNotifyReadEnum::UNREAD,
                    'type' => TypeNotifyReadEnum::OVERTIME_APPROVAL,
                    'color'=> ColorEnum::WARNING
                ]);

                $manager->update([
                    'unread_notification' => $manager->unread_notification ? $manager->unread_notification + 1 : 1
                ]);
            }

            DB::commit();
            return redirect()->route('overtimes.index')
                ->with([
                    'message' => Lang::get('messages.overtime-send_s'),
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
            $overtime = Overtimes::findOrFail($id);

            $overtime->update([
                'status' => StatusOverTimeEnum::DONE,
            ]);

            $user = User::find($overtime->created_by);
            if ($user) {
                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'Yêu cầu tăng ca đã được duyệt',
                    'content' => 'Yêu cầu tăng ca của bạn đã được duyệt (Mã: ' . $overtime->code . ')',
                    'link' => route('overtimes.show', $overtime->id),
                    'is_read' => StatusNotifyReadEnum::UNREAD,
                    'type' => TypeNotifyReadEnum::OVERTIME_APPROVAL,
                    'color'=> ColorEnum::SUCCESS
                ]);

                $user->update([
                    'unread_notification' => $user->unread_notification ? $user->unread_notification + 1 : 1
                ]);
            }

            DB::commit();
            return redirect()->route('overtimes.index')
                ->with([
                    'message' => Lang::get('messages.overtime-approve_s'),
                    'status' => 'success'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Reject overtime request and notify the requester
     */
    public function reject(string $id)
    {
        DB::beginTransaction();
        try {
            $overtime = Overtimes::findOrFail($id);

            $overtime->update([
                'status' => StatusOverTimeEnum::REJECT,
            ]);

            $user = User::find($overtime->created_by);
            if ($user) {
                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'Yêu cầu tăng ca đã bị từ chối',
                    'content' => 'Yêu cầu tăng ca của bạn đã bị từ chối (Mã: ' . $overtime->code . ')',
                    'link' => route('overtimes.show', $overtime->id),
                    'is_read' => StatusNotifyReadEnum::UNREAD,
                    'type' => TypeNotifyReadEnum::OVERTIME_APPROVAL,
                    'color'=> ColorEnum::DANGER
                ]);

                $user->update([
                    'unread_notification' => $user->unread_notification ? $user->unread_notification + 1 : 1
                ]);
            }

            DB::commit();
            return redirect()->route('overtimes.index')
                ->with([
                    'message' => Lang::get('messages.overtime-reject_s'),
                    'status' => 'success'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
