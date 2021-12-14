<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;

class EmailController extends Controller
{
    public function welcome()
    {
        $user = User::find(5);
        SendWelcomeEmailJob::dispatch($user)->delay(Carbon::now()->addSeconds(5));
        return view('mails.welcome');
    }
}
