<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;

use App\Models\User;

class UserPolicy
{
    
    public function viewAny($user)
    {
        return $user->can('view_users') || $user->can('create_users') || $user->can('edit_users') || $user->can('delete_users');
    }

    public function view($user)
    {
        return $user->can('view_users');
    }

    public function create($user)
    {
        return $user->can('create_users');
    }

    public function update($user)
    {
        return $user->can('edit_users');
    }

    public function delete($user)
    {
        return $user->can('delete_users');
    }

    public function deleteAny(User $user) : bool
    {
        return $user->can('delete_users');
    }
}
