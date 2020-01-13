<?php

namespace App\Policies;

use App\Place;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlacePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any places.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the place.
     *
     * @param  \App\User  $user
     * @param  \App\Place  $place
     * @return mixed
     */
    public function view(User $user, Place $place)
    {
        return $place->user_id === $user->id;
    }

    /**
     * Determine whether the user can create places.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the place.
     *
     * @param  \App\User  $user
     * @param  \App\Place  $place
     * @return mixed
     */
    public function update(User $user, Place $place)
    {
        return $place->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the place.
     *
     * @param  \App\User  $user
     * @param  \App\Place  $place
     * @return mixed
     */
    public function delete(User $user, Place $place)
    {
        return $place->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the place.
     *
     * @param  \App\User  $user
     * @param  \App\Place  $place
     * @return mixed
     */
    public function restore(User $user, Place $place)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the place.
     *
     * @param  \App\User  $user
     * @param  \App\Place  $place
     * @return mixed
     */
    public function forceDelete(User $user, Place $place)
    {
        //
    }
}
