<?php

namespace App\Policies;

use App\Models\User;

class PlayerPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create($user){
        //return Auth::check();
        return $user -> is_admin;
    }

    public function update($user){
        return $user -> is_admin;
    }

    public function delete($user){
        return $user -> is_admin;
    }
}
