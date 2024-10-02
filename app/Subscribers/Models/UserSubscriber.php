<?php

namespace App\Subscribers\Models;

use App\Events\Models\User\UserCreated;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Events\Dispatcher;

class UserSubscriber
{
    // Event subscriber is a class that let us group our event - listener mappings in one place.
    public function subscribe (Dispatcher $event) 
    {
        $event->listen(UserCreated::class, SendWelcomeEmail::class);
    }
}