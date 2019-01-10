<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class AdminRegistered
{
    use  SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $user;

    public function __construct($user)
    {
        //
        $this->user=$user;
    }


}
