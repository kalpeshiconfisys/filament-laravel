<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    /**
     * View permissions list
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_permissions');
    }

    /**
     * View single permission
     */
    public function view(User $user, Permission $permission): bool
    {
        return $user->can('view_permissions');
    }

    /**
     * Create permission
     */
    public function create(User $user): bool
    {
        return $user->can('create_permissions');
    }

    /**
     * Update permission
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->can('edit_permissions');
    }

    /**
     * Delete permission
     */
    public function delete(User $user, Permission $permission): bool
    {
        return $user->can('delete_permissions');
    }

    /**
     * Restore permission
     */
    public function restore(User $user, Permission $permission): bool
    {
        return $user->can('delete_permissions');
    }

    /**
     * Force delete permission
     */
    public function forceDelete(User $user, Permission $permission): bool
    {
        return $user->can('delete_permissions');
    }
}
