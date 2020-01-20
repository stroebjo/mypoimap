<?php

namespace App\Policies;

use App\JourneyEntry;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JourneyEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any journey entries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the journey entry.
     *
     * @param  \App\User  $user
     * @param  \App\JourneyEntry  $journeyEntry
     * @return mixed
     */
    public function view(User $user, JourneyEntry $journeyEntry)
    {
        return false;
    }

    /**
     * Determine whether the user can create journey entries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the journey entry.
     *
     * @param  \App\User  $user
     * @param  \App\JourneyEntry  $journeyEntry
     * @return mixed
     */
    public function update(User $user, JourneyEntry $journeyEntry)
    {
        return $journeyEntry->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the journey entry.
     *
     * @param  \App\User  $user
     * @param  \App\JourneyEntry  $journeyEntry
     * @return mixed
     */
    public function delete(User $user, JourneyEntry $journeyEntry)
    {
        return $journeyEntry->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the journey entry.
     *
     * @param  \App\User  $user
     * @param  \App\JourneyEntry  $journeyEntry
     * @return mixed
     */
    public function restore(User $user, JourneyEntry $journeyEntry)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the journey entry.
     *
     * @param  \App\User  $user
     * @param  \App\JourneyEntry  $journeyEntry
     * @return mixed
     */
    public function forceDelete(User $user, JourneyEntry $journeyEntry)
    {
        //
    }
}
