<?php

namespace App\Http\Controllers;

use App\Models\DayOffsUser;
use Illuminate\Http\Request;
class DayOffUserController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function getByUser(Request $request)
    {
        $dayOffUser = DayOffsUser::where('user_id', $request->user_id)
            ->whereYear('start_at', now()->year)
            ->first();

        return response()->json([
            'status'=> 1,
            'data'=> $dayOffUser
        ]);
    }


}
