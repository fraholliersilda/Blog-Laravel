<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\UserCountMonthlyMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Log;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly user count email to all admins';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $admins = User::where('role_id', 1)->pluck('email');

        foreach ($admins as $adminEmail) {
            Mail::to($adminEmail)->send(new UserCountMonthlyMail());
        }

        // Log::channel('emails')->info('Monthly user count email sent to all admins.');

        $this->info('Monthly user count email sent to all admins.');
    }
}
