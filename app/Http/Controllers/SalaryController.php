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
use App\Http\Requests\SalaryRequest;
use App\Models\ConfigModel;
use App\Models\DayOffs;
use App\Models\Notifications;
use App\Models\Salary;
use App\Models\DayOffsUser;
use App\Models\KPIDetail;
use App\Models\Overtimes;
use App\Models\SalaryCalculate;
use App\Models\SalaryDetails;
use App\Models\Timekeeping;
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
    public function store(SalaryRequest $request)
    {
        DB::beginTransaction();
        try {
            $dateNow = Carbon::now()->format('m/Y');
            // Lấy ngày đầu và ngày cuối của tháng hiện tại
            $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

            $userItem = User::findOrFail($request->user_id);
            $userId = Auth::user()->id;

            $result = Salary::create(
                attributes: [
                    'code' => $this->genderEnumCode(),
                    'name' => 'Phiếu lương của ' . $userItem->name . ' cho tháng ' .  $dateNow,
                    'user_id' => $userId,
                    'start_at' => $startOfMonth,
                    'end_at' => $endOfMonth,
                    'status' => SalaryStatusEnum::DRAFT
                ]
            );

            $timeKeeping = Timekeeping::where('user_id', $userId)
                ->whereBetween('checkin', [$startOfMonth, $endOfMonth])
                ->get();
            // Tính tổng num_work_date
            $totalWorkDays = $timeKeeping->sum('num_work_date');
            $countWorkLate = $timeKeeping->where('work_late', '>', 0)->count();

            SalaryDetails::create([
                'salary_id' => $result->id,
                'name' => 'Ngày công tiêu chuẩn',
                'code' => 'STANDARD_WORKDAY',
                'num_day' => getDayOfMonth()
            ]);
            SalaryDetails::create([
                'salary_id' => $result->id,
                'name' => 'Ngày công thực',
                'code' => 'WORK100',
                'num_day' => $totalWorkDays
            ]);
            SalaryDetails::create([
                'salary_id' => $result->id,
                'name' => 'Công ăn',
                'code' => 'LUNCH',
                'num_day' => $totalWorkDays
            ]);


            $totalDayOffs = DayOffs::whereBetween('start_at', [$startOfMonth, $endOfMonth])
                ->sum('num');
            SalaryDetails::create([
                'salary_id' => $result->id,
                'name' => 'Ngày nghỉ phép',
                'code' => 'OFFDAY100',
                'num_day' => $totalDayOffs
            ]);

            $overtimes = Overtimes::whereBetween('actual_start', [$startOfMonth, $endOfMonth])
                ->sum('actual_time');

            SalaryDetails::create([
                'salary_id' => $result->id,
                'name' => 'Tăng ca',
                'code' => 'WORK200',
                'num_day' => $overtimes
            ]);

            // tính toán
            $salaryInsurance = $userItem->salary_insurance;
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'LCSHS',
                'name' => '	Lương đóng BHXH CBNV',
                'total' => $salaryInsurance,
                'description' => 'Cơ sở'
            ]);

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'LTTNV',
                'name' => '	Lương thỏa thuận CBNV',
                'total' => $userItem->salary ?? 0 + $userItem->salary_kpi ?? 0,
                'description' => 'Hệ số lương cơ bản'
            ]);
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'LTTCBNVHS',
                'name' => '	Lương cơ bản thỏa thuận CBNV (Hệ số)',
                'total' => $userItem->salary,
                'description' => 'Hệ số lương cơ bản'

            ]);
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'LKPITTNV',
                'name' => '	Lương KPI thỏa thuận CBNV (Hệ số)',
                'total' => $userItem->salary_kpi,
                'description' => 'Hệ số lương cơ bản'
            ]);


            $realSalary = $userItem->salary / getDayOfMonth() * $totalWorkDays;
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'LTTCBNVHS',
                'name' => '	Lương cơ bản thực tế CBNV (Hệ số)',
                'total' => $realSalary,
                'type' => SalaryCalculate::ADD,
                'description' => 'Cơ sở'
            ]);

            $salaryKpi = $userItem->salary_kpi;
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'LKPITTNV',
                'name' => '	Lương KPI thực tế CBNV (Hệ số)',
                'total' => $salaryKpi,
                'type' => SalaryCalculate::ADD,
                'description' => 'Cơ sở'

            ]);

            $default_lunch_money = ConfigModel::getSetting('default_lunch_money');

            $lunchSalary = $default_lunch_money * $totalWorkDays;
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'PCA',
                'name' => 'Phụ cấp tiền ăn CBNV',
                'total' => $lunchSalary,
                'type' => SalaryCalculate::ADD,
                'description' => 'Phụ cấp'
            ]);

            $TT = 0;

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'TT',
                'name' => 'Truy thu',
                'total' => $TT,
                'type' => SalaryCalculate::SUB,
                'description' => 'Giảm trừ'
            ]);

            $TL = 0;
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'TL',
                'name' => 'Truy lĩnh',
                'total' => $TL,
                'type' => SalaryCalculate::ADD,
                'description' => 'Phụ cấp'
            ]);

            $salaryOT200 = $overtimes > 0 ? $overtimes * ($userItem->salary / getDayOfMonth() / 8) : 0;

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'OT200',
                'name' => 'Lương OT 200%',
                'total' => $salaryOT200,
                'type' => SalaryCalculate::ADD,
                'description' => 'Cơ sở'

            ]);

            $salaryDayOff = $totalDayOffs * ($userItem->salary / getDayOfMonth());
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'LPNV032021',
                'name' => '	Lương phép CBNV',
                'total' => $salaryDayOff,
                'type' => SalaryCalculate::ADD,
                'description' => 'Hệ số lương cơ bản'
            ]);

            $totalSalary = $realSalary + $salaryKpi + $lunchSalary + $salaryOT200 + $salaryDayOff + $TL - $TL;
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'TTNNV032021',
                'name' => '	Tổng thu nhập CBNV',
                'total' => $totalSalary,
                'description' => 'Tổng'
            ]);


            $bhxh_percent = ConfigModel::getSetting('bhxh_percent');
            $salaryBHXH = $salaryInsurance * $bhxh_percent;

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'BHXHNV',
                'name' => 'Bảo hiểm xã hội CBNV',
                'total' => $salaryBHXH,
                'type' => SalaryCalculate::SUB,
                'description' => 'Giảm trừ'
            ]);

            $bhyt_percent = ConfigModel::getSetting('bhyt_percent');
            $salaryBHYT = $salaryInsurance * $bhyt_percent;

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'BHYTNV',
                'name' => 'Bảo hiểm y tế CBNV',
                'total' => $salaryBHYT,
                'type' => SalaryCalculate::SUB,
                'description' => 'Giảm trừ'
            ]);

            $bhtn_percent = ConfigModel::getSetting('bhtn_percent');
            $salaryBHTN = $salaryInsurance * $bhtn_percent;

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'BHTNNV',
                'name' => 'Bảo hiểm thất nghiệp CBNV',
                'total' => $salaryBHTN,
                'type' => SalaryCalculate::SUB,
                'description' => 'Giảm trừ'
            ]);

            $totalSalaryTax = $totalSalary  -  $salaryBHXH - $salaryBHYT - $salaryBHTN;

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'TNCTNV2022HS',
                'name' => 'Thu nhập chịu thuế CBNV (Hệ số)',
                'total' => $totalSalaryTax,
                'description' => 'Tính thuế thu nhập cá nhân'
            ]);

            $taxableIncome = $totalSalaryTax - 11 * 1000000;

            if ($taxableIncome < 0) {
                $taxableIncome = 0;
            }
            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'TNTTNV032021HS',
                'name' => 'Thu nhập tính thuế CBNV (Hệ số)',
                'total' => $taxableIncome,
                'description' => 'Tính thuế thu nhập cá nhân'
            ]);

            $caculatSalaryTax = 0;
            switch ($taxableIncome) {
                case $taxableIncome < 5 * 1000000:
                    $caculatSalaryTax = $taxableIncome * 5 / 100;
                    break;
                case 5 * 1000000 <= $taxableIncome && $taxableIncome  < 10 * 1000000:
                    $caculatSalaryTax = $taxableIncome * 10 / 100 - (0.25 * 1000000);
                    break;
                case 10 * 1000000 <= $taxableIncome && $taxableIncome  < 18 * 1000000:
                    $caculatSalaryTax = $taxableIncome * 15 / 100 - (0.75 * 1000000);
                    break;
                case 18 * 1000000 <=  $taxableIncome && $taxableIncome  < 32 * 1000000:
                    $caculatSalaryTax = $taxableIncome * 20 / 100 - (1.65 * 1000000);
                    break;
                case 32 * 1000000 <= $taxableIncome  && $taxableIncome < 52 * 1000000:
                    $caculatSalaryTax = $taxableIncome * 25 / 100 - (3.25 * 1000000);
                    break;
                case 52 * 1000000 <= $taxableIncome  && $taxableIncome < 80 * 1000000:
                    $caculatSalaryTax = $taxableIncome * 30 / 100 - (5.85 * 1000000);
                    break;
                case 80 * 1000000 <= $taxableIncome:
                    $caculatSalaryTax = $taxableIncome * 35 / 100 - (9.85 * 1000000);
                    break;
                default:
                    # code...
                    break;
            }

            if ($caculatSalaryTax < 0) {
                $caculatSalaryTax = 0;
            }

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'TNCNNV032021HS',
                'name' => '	Thuế thu nhập cá nhân CBNV (Hệ số)',
                'total' => $caculatSalaryTax,
                'type' => SalaryCalculate::SUB,
                'description' => 'Giảm trừ'
            ]);

            $union_dues = ConfigModel::getSetting('union_dues');

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'PCDNV',
                'name' => 'Phí công đoàn CBNV',
                'total' => $union_dues,
                'type' => SalaryCalculate::SUB,
                'description' => 'Giảm trừ'
            ]);


            $totalEnd = $totalSalaryTax - $union_dues - $caculatSalaryTax;

            SalaryCalculate::create([
                'salary_id' => $result->id,
                'code' => 'NETNVHS',
                'name' => '	Lương Thực Lĩnh CBNV (Hệ số)',
                'total' => $totalEnd,
                'description' => 'Lợi nhuận ròng'
            ]);

            DB::commit();
            return redirect()->route('salary.edit', $result->id)
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
                'details',
                'calculates'
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
        return 'SAL' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
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
