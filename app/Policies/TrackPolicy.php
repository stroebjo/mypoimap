<?php

namespace App\Policies;

use App\Track;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tracks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the track.
     *
     * @param  \App\User  $user
     * @param  \App\Track  $track
     * @return mixed
     */
    public function view(User $user, Track $track)
    {
        return $track->user_id === $user->id;
    }

    /**
     * Determine whether the user can create tracks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the track.
     *
     * @param  \App\User  $user
     * @param  \App\Track  $track
     * @return mixed
     */
    public function update(User $user, Track $track)
    {
        return $track->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the track.
     *
     * @param  \App\User  $user
     * @param  \App\Track  $track
     * @return mixed
     */
    public function delete(User $user, Track $track)
    {
        return $track->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the track.
     *
     * @param  \App\User  $user
     * @param  \App\Track  $track
     * @return mixed
     */
    public function restore(User $user, Track $track)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the track.
     *
     * @param  \App\User  $user
     * @param  \App\Track  $track
     * @return mixed
     */
    public function forceDelete(User $user, Track $track)
    {
        //
    }
}
