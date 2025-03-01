<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimekeepingController extends Controller
{
    public function index(Request $request): View
    {
        return view('pages.timekeeping.index');
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
        $user = Auth::user();
        $storedDescriptor = json_decode($user->face_descriptor, true);
        $capturedDescriptor = $request->descriptor;

        $distance = $this->calculateDistance($storedDescriptor, $capturedDescriptor);

        return response()->json([
            'match' => $distance < 0.6 // Điều chỉnh ngưỡng theo nhu cầu
        ]);
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
