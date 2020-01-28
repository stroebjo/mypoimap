<?php

namespace App\Policies;

use App\Journey;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JourneyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any journeys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the journey.
     *
     * @param  \App\User  $user
     * @param  \App\Journey  $journey
     * @return mixed
     */
    public function view(User $user, Journey $journey)
    {
        return $journey->user_id === $user->id;
    }

    /**
     * Determine whether the user can export the journey as gpx file.
     *
     * @param  \App\User  $user
     * @param  \App\Journey  $journey
     * @return mixed
     */
    public function gpx(User $user, Journey $journey)
    {
        return $journey->user_id === $user->id;
    }

    /**
     * Determine whether the user can create journeys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the journey.
     *
     * @param  \App\User  $user
     * @param  \App\Journey  $journey
     * @return mixed
     */
    public function update(User $user, Journey $journey)
    {
        return $journey->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the journey.
     *
     * @param  \App\User  $user
     * @param  \App\Journey  $journey
     * @return mixed
     */
    public function delete(User $user, Journey $journey)
    {
        return $journey->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the journey.
     *
     * @param  \App\User  $user
     * @param  \App\Journey  $journey
     * @return mixed
     */
    public function restore(User $user, Journey $journey)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the journey.
     *
     * @param  \App\User  $user
     * @param  \App\Journey  $journey
     * @return mixed
     */
    public function forceDelete(User $user, Journey $journey)
    {
        //
    }
}
