<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Mail\UserCountMonthlyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command(
    'emails:send',
    function () {
        $admins = User::where('role_id', 1)->pluck('email');

        foreach ($admins as $adminEmail) {
            Mail::to($adminEmail)->send(new UserCountMonthlyMail());
        }
        $this->info('Monthly user count email sent to all admins.');
    })->describe('Send monthly user count email to all admins');


Schedule::command('emails:send')->monthly();
