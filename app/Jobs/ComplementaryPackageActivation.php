<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\Dashboard\User;
use App\Models\Package;
use App\Notifications\AdminAssignedComplementaryPackageMail;
use App\Notifications\AssignedComplementaryPackage;

use App\Notifications\AssignedComplementaryPackageMail;
use App\Notifications\UsersErrorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ComplementaryPackageActivation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    protected $package;

    public function __construct($user, $package)
    {
        $this->user = $user;
        $this->package = $package;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::getUserById($this->user);

        $package = (new \App\Models\Package)->getPackageFromId($this->package);

        $user->notify(new AssignedComplementaryPackage($package));

        Notification::send($user, new AssignedComplementaryPackageMail($package, $user));

        $admins = Admin::getAdminsByRoleName('Emails Administrator');

        Notification::send($admins, new AdminAssignedComplementaryPackageMail($package, $user));

    }
}
