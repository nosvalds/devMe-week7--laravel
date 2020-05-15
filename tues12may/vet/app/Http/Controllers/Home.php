<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use Auth;

class Home extends Controller
{
    // index
    public function index()
    {
        $user = Auth::user();

        $hour = Carbon::now()->hour;
        if ($hour < 12) {
            $timeOfDay = "Morning";
        } elseif ($hour < 17) {
            $timeOfDay = "Afternoon";
        } else {
            $timeOfDay = "Evening";
        }
        return view("welcome",['page' => 'Home', 'timeOfDay' => $timeOfDay, 'user' => $user]);
    }
}
