<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SendMonthlyReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nevermore:reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly reports to superadmins';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Send notification to admins
        Notification::send(User::where('role_id', 1)->get(), new SendMonthlyReport);
    }
}
