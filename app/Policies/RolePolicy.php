<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    /**
     * View roles list
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_roles');
    }

    /**
     * View single role
     */
    public function view(User $user, Role $role): bool
    {
        return $user->can('view_roles');
    }

    /**
     * Create role
     */
    public function create(User $user): bool
    {
        return $user->can('create_roles');
    }

    /**
     * Update role
     */
    public function update(User $user, Role $role): bool
    {
        return $user->can('edit_roles');
    }

    /**
     * Delete role
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->can('delete_roles');
    }

    /**
     * Restore role
     */
    public function restore(User $user, Role $role): bool
    {
        return $user->can('delete_roles');
    }

    /**
     * Force delete role
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return $user->can('delete_roles');
    }
    
}
