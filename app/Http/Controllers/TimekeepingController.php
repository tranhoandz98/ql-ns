<?php

namespace App\Http\Controllers;

use App\Enums\User\TypeGroupCheckInEnum;
use App\Enums\User\TypeUserEnum;
use App\Http\Requests\TimekeepingRequest;
use App\Models\ConfigModel;
use App\Models\Timekeeping;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class TimekeepingController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->perPage ?? 10;
        $groupBy = $request->group_by;

        $query = Timekeeping::with(['user:id,name,code'])
            ->where(function ($query) use ($request) {
                if (!empty($request->user_id)) {
                    $query->where('user_id', $request->user_id);
                }
                if (!empty($request->checkin)) {
                    $dates = explode(' to ', $request->checkin);
                    if (count($dates) === 2) {
                        $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                        $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                        $query->whereBetween('checkin', [$startDate->startOfDay(), $endDate->endOfDay()]);
                    }
                }
                $user = Auth::user();
                if ($user) {
                    if ($user->type === TypeUserEnum::NHAN_VIEN->value) {
                        // For regular employees, only show their own records
                        $query->where('user_id', $user->id);
                    }
                }
            });

        // Define the grouping format based on the input
        $groupFormat = match ($groupBy) {
            TypeGroupCheckInEnum::MONTH->value => '%Y-%m',
            TypeGroupCheckInEnum::YEAR->value => '%Y',
            default => '%Y-%m' // Default to monthly grouping
        };

        $listAll = $query->select([
            'user_id',
            DB::raw("DATE_FORMAT(checkin, '$groupFormat') as group_period"),
            DB::raw('COUNT(id) as total_records'),
            DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(work_time))), "%H:%i") as total_work_time'),
            DB::raw('SUM(num_work_date) as total_work_days'),
            DB::raw('SUM(work_late) as total_late_minutes'),
            DB::raw('MIN(checkin) as first_checkin'),
            DB::raw('MAX(checkout) as last_checkout')
        ])
            ->groupBy('user_id', 'group_period')
            ->orderBy('group_period', 'desc')
            ->get()
            ->map(function ($parent) use ($groupFormat) {
                // Get child records for each group
                $parent->records = Timekeeping::where('user_id', $parent->user_id)
                    ->whereRaw("DATE_FORMAT(checkin, '$groupFormat') = ?", [$parent->group_period])
                    ->orderBy('checkin', 'asc')
                    ->get([
                        'id',
                        'checkin',
                        'checkout',
                        'work_time',
                        'num_work_date',
                        'work_late',
                        'created_at'
                    ]);
                return $parent;
            });

        $users = User::select(['id', 'name', 'code', 'status'])->get();
        $typeGroupCheckInEnum = TypeGroupCheckInEnum::options();

        return view(
            'pages.timekeeping.index',
            compact(
                'listAll',
                'users',
                'typeGroupCheckInEnum'
            )
        );
    }

    public function addMe(Request $request): View
    {
        return view('pages.timekeeping.add-me');
    }

    public function postAddMe(Request $request)
    {
        return view('pages.timekeeping.add-me');
    }

    public function checkin(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $storedDescriptor = json_decode($user->face_descriptor, true);
            $capturedDescriptor = $request->descriptor;
            $distance = $this->calculateDistance($storedDescriptor, $capturedDescriptor);
            $match = $distance > 0.2;

            $dateNow = Carbon::now();
            if ($match) {
                $timeKeeping = Timekeeping::where('user_id', $user->id)
                    ->whereDate('checkin', $dateNow)
                    ->first();

                if (!$timeKeeping) {
                    $timeKeeping = new Timekeeping();
                }
                $timeKeeping->user_id = $user->id;
                if ($timeKeeping->checkin) {
                    $timeCheckOut = Carbon::now();
                    $timeKeeping->checkout = $timeCheckOut;

                    $timeCheckIn = Carbon::parse($timeKeeping->checkin);
                    // $timeCheckIn = Carbon::parse('2025-03-17 08:30:07');
                    // $timeCheckOut = Carbon::parse('2025-03-17 18:00:07');

                    $workMinutes = $timeCheckIn->diffInMinutes($timeCheckOut);
                    $breakTime = (int)ConfigModel::getSetting('break_time'); // Giờ nghỉ 90 phút

                    // Nếu thời gian làm việc lớn hơn 4 giờ thì trừ đi giờ nghỉ
                    if ($workMinutes > (4 * 60)) {
                        $workMinutes -= $breakTime;
                    }

                    $hours = floor($workMinutes / 60);
                    $minutes = $workMinutes % 60;
                    $formattedWorkTime = sprintf('%02d:%02d', $hours, $minutes);
                    $timeKeeping->work_time = $formattedWorkTime;

                    $numWorkDate = round(min(1, $workMinutes / (8 * 60)), 2);
                    $timeKeeping->num_work_date = $numWorkDate;
                } else {
                    $timeKeeping->checkin = Carbon::now();
                }

                $checkInTime = Carbon::parse($timeKeeping->checkin);
                $userWorkTime = Carbon::parse($dateNow->format('Y-m-d') . ' ' . $user->work_time); // Thời gian làm việc quy định

                // Kiểm tra nếu userWorkTime có giá trị hợp lệ
                if (!$user->work_time) {
                    $timeKeeping->work_late = 0; // Không có giờ làm quy định thì không tính đi muộn
                } else {
                    if ($checkInTime > $userWorkTime) {
                        // Tính số phút đi muộn (checkin - giờ quy định)
                        $lateMinutes = $userWorkTime->diffInMinutes($checkInTime);
                        $timeKeeping->work_late = round($lateMinutes, 2);
                    } else {
                        $timeKeeping->work_late = 0; // Không đi muộn
                    }
                }

                $timeKeeping->save();
            }
            DB::commit();
            return response()->json([
                'distance' => $distance,
                'match' => $match,
                // Điều chỉnh ngưỡng theo nhu cầu
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function calculateDistance($arr1, $arr2)
    {
        $sum = 0;
        foreach ($arr1 as $i => $val) {
            $sum += pow($val - $arr2[$i], 2);
        }
        return sqrt($sum);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select(['id', 'name', 'code', 'status'])->active()->get();

        return view(
            'pages.timekeeping.create',
            compact('users')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TimekeepingRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = User::findOrFail($request->user_id);

            $timeCheckIn = Carbon::createFromFormat('d/m/Y H:i', $request->checkin);
            $timeCheckInFormat = $timeCheckIn->format('Y-m-d H:i:s');
            $timeCheckOut = Carbon::createFromFormat('d/m/Y H:i', $request->checkout);
            $timeCheckOutFormat = $timeCheckOut->format('Y-m-d H:i:s');

            $workMinutes = $timeCheckIn->diffInMinutes($timeCheckOut);
            $breakTime = (int)ConfigModel::getSetting('break_time'); // Giờ nghỉ 90 phút

            // Nếu thời gian làm việc lớn hơn 4 giờ thì trừ đi giờ nghỉ
            if ($workMinutes > (4 * 60)) {
                $workMinutes -= $breakTime;
            }

            $hours = floor($workMinutes / 60);
            $minutes = $workMinutes % 60;
            $formattedWorkTime = sprintf('%02d:%02d', $hours, $minutes);

            $numWorkDate = round(min(1, $workMinutes / (8 * 60)), 2);

            $timeKeeping = new Timekeeping();

            $timeKeeping->user_id = $user->id;
            $timeKeeping->checkin = $timeCheckInFormat;
            $timeKeeping->checkout = $timeCheckOutFormat;
            $timeKeeping->work_time = $formattedWorkTime;
            $timeKeeping->num_work_date = $numWorkDate;

            $userWorkTime = Carbon::parse($timeCheckIn->format('Y-m-d') . ' ' . $user->work_time); // Thời gian làm việc quy định

            // Kiểm tra nếu userWorkTime có giá trị hợp lệ
            if (!$user->work_time) {
                $timeKeeping->work_late = 0; // Không có giờ làm quy định thì không tính đi muộn
            } else {
                if ($timeCheckIn > $userWorkTime) {
                    // Tính số phút đi muộn (checkin - giờ quy định)
                    $lateMinutes = $userWorkTime->diffInMinutes($timeCheckIn);
                    $timeKeeping->work_late = round($lateMinutes, 2);
                } else {
                    $timeKeeping->work_late = 0; // Không đi muộn
                }
            }
            $timeKeeping->save();

            DB::commit();

            return redirect()->route('timekeeping.index')
                ->with(
                    ['message' => Lang::get('messages.timekeeping-create_s'), 'status' => 'success']
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $result = Timekeeping::with(
            []
        )->find($id);
        $users = User::select(['id', 'name', 'code', 'status'])->active()->get();


        return view('pages.timekeeping.edit', compact(
            'result',
            'users'

        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TimekeepingRequest $request, string $id)
    {

        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->user_id);

            $timeKeeping = Timekeeping::findOrFail($id);
            $timeCheckIn = Carbon::createFromFormat('d/m/Y H:i', $request->checkin);
            $timeCheckInFormat = $timeCheckIn->format('Y-m-d H:i:s');
            $timeCheckOut = Carbon::createFromFormat('d/m/Y H:i', $request->checkout);
            $timeCheckOutFormat = $timeCheckOut->format('Y-m-d H:i:s');

            $workMinutes = $timeCheckIn->diffInMinutes($timeCheckOut);
            $breakTime = (int)ConfigModel::getSetting('break_time'); // Giờ nghỉ 90 phút

            // Nếu thời gian làm việc lớn hơn 4 giờ thì trừ đi giờ nghỉ
            if ($workMinutes > (4 * 60)) {
                $workMinutes -= $breakTime;
            }

            $hours = floor($workMinutes / 60);
            $minutes = $workMinutes % 60;
            $formattedWorkTime = sprintf('%02d:%02d', $hours, $minutes);

            $numWorkDate = round(min(1, $workMinutes / (8 * 60)), 2);

            $timeKeeping->user_id = $user->id;
            $timeKeeping->checkin = $timeCheckInFormat;
            $timeKeeping->checkout = $timeCheckOutFormat;
            $timeKeeping->work_time = $formattedWorkTime;
            $timeKeeping->num_work_date = $numWorkDate;

            $userWorkTime = Carbon::parse($timeCheckIn->format('Y-m-d') . ' ' . $user->work_time); // Thời gian làm việc quy định

            // Kiểm tra nếu userWorkTime có giá trị hợp lệ
            if (!$user->work_time) {
                $timeKeeping->work_late = 0; // Không có giờ làm quy định thì không tính đi muộn
            } else {
                if ($timeCheckIn > $userWorkTime) {
                    // Tính số phút đi muộn (checkin - giờ quy định)
                    $lateMinutes = $userWorkTime->diffInMinutes($timeCheckIn);
                    $timeKeeping->work_late = round($lateMinutes, 2);
                } else {
                    $timeKeeping->work_late = 0; // Không đi muộn
                }
            }
            $timeKeeping->save();
            DB::commit();
            return redirect()->route('timekeeping.index')
                ->with(
                    ['message' => Lang::get('messages.timekeeping-update_s'), 'status' => 'success']
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function destroy(string $id)
    {
        //
        $record = Timekeeping::find($id);
        $record->delete();
        return redirect()->route('timekeeping.index')
            ->with(
                ['message' => Lang::get('messages.timekeeping-delete_s'), 'status' => 'success']
            );
    }
}
