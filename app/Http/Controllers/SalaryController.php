<?php

namespace App\Http\Controllers;

use App\Enums\DayOff\StatusDayOffEnum;
use App\Enums\DayOff\TypeDayOffEnum;
use App\Enums\DayOff\TypeSessionDayOffEnum;
use App\Enums\Salary\SalaryStatusEnum;
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
use App\Models\Salary;
use App\Models\DayOffsUser;
use App\Models\KPIDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class SalaryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $groupBy = $request->group_by;

        $query = Salary::with([
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
                    if ($user->type !== TypeUserEnum::ADMIN->value) {
                        // Nếu không phải ADMIN, chỉ lấy các bản ghi của chính họ và trạng thái "done"
                        $query->where('user_id', $user->id)
                            ->where('status', SalaryStatusEnum::DONE->value);
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
                    $parent->records = Salary::where('user_id', $parent->user_id)
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

        $salaryStatusEnum = SalaryStatusEnum::options();
        $typeGroupEnum = TypeGroupEnum::options();

        return view('pages.salary.index', compact(
            'listAll',
            'users',
            'salaryStatusEnum',
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
            'pages.salary.create',
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
            $result = Salary::create(
                [
                    'code' => $this->genderEnumCode(),
                    'name' => $request->name,
                    'user_id' => $request->user_id,
                    'start_at' => Carbon::createFromFormat('d/m/Y', $request->start_at)->format('Y-m-d'),
                    'end_at' => Carbon::createFromFormat('d/m/Y', $request->end_at)->format('Y-m-d'),
                    'note' => $request->note,
                    'description' => $request->description,
                    'num' => $request->num,
                    'status' => StatusApproveEnum::DRAFT
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
            return redirect()->route('salary.index')
                ->with(
                    ['message' => Lang::get('messages.salary-create_s'), 'status' => 'success']
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
        $result = Salary::with(
            [
                'createdByData:id,name',
                'updatedByData:id,name',
                'details'
            ]
        )->find($id);

        $users = User::select(['id', 'name', 'code'])->active()->get();
        $statusApproveEnum = StatusApproveEnum::options();

        return view('pages.salary.show', compact(
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

        $result = Salary::with(
            [
                'details'
            ]
        )->find($id);
        $users = User::select(['id', 'name', 'code'])->active()->get();

        return view('pages.salary.edit', compact(
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
            $result = Salary::findOrFail($id);

            $result->update(
                [
                    'name' => $request->name,
                    'user_id' => $request->user_id,
                    'start_at' => Carbon::createFromFormat('d/m/Y', $request->start_at)->format('Y-m-d'),
                    'end_at' => Carbon::createFromFormat('d/m/Y', $request->end_at)->format('Y-m-d'),
                    'note' => $request->note,
                    'description' => $request->description,
                    'num' => $request->num,
                    'status' => StatusApproveEnum::DRAFT
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
            return redirect()->route('salary.index')
                ->with(
                    ['message' => Lang::get('messages.salary-update_s'), 'status' => 'success']
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
        $record = Salary::find($id);
        $record->delete();
        return redirect()->route('salary.index')
            ->with(
                ['message' => Lang::get('messages.salary-delete_s'), 'status' => 'success']
            );
    }

    public function genderEnumCode()
    {
        return 'Salary' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function approve(string $id)
    {
        DB::beginTransaction();
        try {
            $salary = Salary::findOrFail($id);

            $salary->update([
                'status' => StatusDayOffEnum::DONE,
            ]);

            $user = User::find($salary->user_id);
            if ($user) {
                Notifications::create([
                    'user_id' => $user->id,
                    'title' => 'Phiếu lương của bạn đã được duyệt',
                    'content' => 'Phiếu lương của bạn đã được duyệt (Mã: ' . $salary->code . ')',
                    'link' => route('salary.show', $salary->id),
                    'is_read' => StatusNotifyReadEnum::UNREAD,
                    'type' => TypeNotifyReadEnum::SALARY,
                    'color' => ColorEnum::SUCCESS
                ]);

                $user->update([
                    'unread_notification' => $user->unread_notification ? $user->unread_notification + 1 : 1
                ]);
            }

            DB::commit();
            return redirect()->route('salary.index')
                ->with([
                    'message' => Lang::get('messages.salary-approve_s'),
                    'status' => 'success'
                ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
