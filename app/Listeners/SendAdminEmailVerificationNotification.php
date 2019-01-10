<?php

namespace App\Listeners;

use App\Events\AdminRegistered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendAdminEmailVerificationNotification
{

    public function handle(AdminRegistered $event)
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {

            $event->user->sendEmailVerificationNotification();
        }
    }
}
