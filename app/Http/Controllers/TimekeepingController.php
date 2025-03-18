<?php

namespace App\Http\Controllers;

use App\Enums\User\TypeGroupCheckInEnum;
use App\Models\ConfigModel;
use App\Models\TimeKeepings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimekeepingController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->perPage ?? 10;
        $listAll = TimeKeepings::with(['user:id,name,code'])
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
            })
            ->select([
                'user_id',
                DB::raw('DATE_FORMAT(checkin, "%Y-%m") as month'), // Grouping by month
                DB::raw('COUNT(id) as total_records'), // Count records per group
                DB::raw('TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(work_time))), "%H:%i") as total_work_time'),
                DB::raw('SUM(num_work_date) as total_work_days'), // Sum num_work_date for each month
                DB::raw('SUM(work_late) as total_late_minutes'), // Sum work_late for each month
                DB::raw('MIN(checkin) as first_checkin'), // Get earliest check-in per month
                DB::raw('MAX(checkout) as last_checkout') // Get latest checkout per month
            ])
            ->groupBy('user_id', 'month')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($parent) {
                // Lấy danh sách các bản ghi con theo user_id và month
                $parent->records = TimeKeepings::where('user_id', $parent->user_id)
                    ->whereRaw('DATE_FORMAT(checkin, "%Y-%m") = ?', [$parent->month])
                    ->orderBy('checkin', 'asc') // Sắp xếp theo thời gian
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
        // ->paginate($perPage);

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
                $timeKeeping = TimeKeepings::where('user_id', $user->id)
                    ->whereDate('checkin', $dateNow)
                    ->first();

                if (!$timeKeeping) {
                    $timeKeeping = new TimeKeepings();
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
}
