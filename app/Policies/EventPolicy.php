<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // public function delete(User $user, Event $event){
    //     return $user -> is_admin;
    // }

    public function delete(){
        return $user -> is_admin;
    }

    public function create(){
        return $user -> is_admin;
    }
}
