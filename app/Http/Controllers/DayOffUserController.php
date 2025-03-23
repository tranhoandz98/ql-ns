<?php

namespace App\Http\Controllers;

use App\Enums\User\TypeUserEnum;
use App\Models\ConfigModel;
use App\Models\DayOffsUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class DayOffUserController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */


    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $query = DayOffsUser::with([
            'user:id,code,name'
        ])
            ->where(function ($query) use ($request) {
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

        $listAll = $query->orderBy('start_at', 'desc')
            // ->get()
            ->paginate($perPage);

        $users = User::select(['id', 'name', 'code'])->active()->get();

        return view('pages.day_offs_user.index', compact(
            'listAll',
            'users',

        ));
    }

    public function getByUser(Request $request)
    {
        $dayOffUser = DayOffsUser::where('user_id', $request->user_id)
            ->whereYear('start_at', now()->year)
            ->first();

        return response()->json([
            'status' => 1,
            'data' => $dayOffUser
        ]);
    }

    public function createDayOffForAllUsers()
    {
        $users = User::all(); // Get all users
        $currentYear = now()->year;

        $day_off_default = ConfigModel::getSetting('day_off_default') ?? 12;
        foreach ($users as $user) {
            // Check if the user already has a day off record for the current year
            $existingDayOff = DayOffsUser::where('user_id', $user->id)
                ->whereYear('start_at', $currentYear)
                ->exists();

            // If the user does not have a record, create a new day off entry
            if (!$existingDayOff) {
                DayOffsUser::create([
                    'user_id' => $user->id,
                    'start_at' => now()->startOfYear(), // Set the start date to the beginning of the current year
                    'end_at' => now()->endOfYear(), // Set the end date to the end of the current year
                    'num' => $day_off_default, // Default number of days off
                    'remaining_leave' => $day_off_default, // Default number of days off
                ]);
            }
        }

        return redirect()->route('day_offs_user.index')
            ->with(
                ['message' => Lang::get('messages.day_off_user-create_s'), 'status' => 'success']
            );
    }
}
