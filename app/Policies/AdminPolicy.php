<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if user has admin access
     */
    public function adminAccess(User $user): bool
    {
        return $user->role === 'admin';
    }
}
