<?php

namespace App\Policies;

use App\User;
use App\UserCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any user categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the user category.
     *
     * @param  \App\User  $user
     * @param  \App\UserCategory  $userCategory
     * @return mixed
     */
    public function view(User $user, UserCategory $userCategory)
    {
        return $userCategory->user_id === $user->id;
    }

    /**
     * Determine whether the user can create user categories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the user category.
     *
     * @param  \App\User  $user
     * @param  \App\UserCategory  $userCategory
     * @return mixed
     */
    public function update(User $user, UserCategory $userCategory)
    {
        return $userCategory->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the user category.
     *
     * @param  \App\User  $user
     * @param  \App\UserCategory  $userCategory
     * @return mixed
     */
    public function delete(User $user, UserCategory $userCategory)
    {
        return $userCategory->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the user category.
     *
     * @param  \App\User  $user
     * @param  \App\UserCategory  $userCategory
     * @return mixed
     */
    public function restore(User $user, UserCategory $userCategory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the user category.
     *
     * @param  \App\User  $user
     * @param  \App\UserCategory  $userCategory
     * @return mixed
     */
    public function forceDelete(User $user, UserCategory $userCategory)
    {
        //
    }
}
