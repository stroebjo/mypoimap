<?php

namespace App\Policies;

use App\User;
use App\Visit;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any visits.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the visit.
     *
     * @param  \App\User  $user
     * @param  \App\Visit  $visit
     * @return mixed
     */
    public function view(User $user, Visit $visit)
    {
        return $visit->user_id === $user->id;
    }

    /**
     * Determine whether the user can create visits.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the visit.
     *
     * @param  \App\User  $user
     * @param  \App\Visit  $visit
     * @return mixed
     */
    public function update(User $user, Visit $visit)
    {
        return $visit->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the visit.
     *
     * @param  \App\User  $user
     * @param  \App\Visit  $visit
     * @return mixed
     */
    public function delete(User $user, Visit $visit)
    {
        return $visit->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the visit.
     *
     * @param  \App\User  $user
     * @param  \App\Visit  $visit
     * @return mixed
     */
    public function restore(User $user, Visit $visit)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the visit.
     *
     * @param  \App\User  $user
     * @param  \App\Visit  $visit
     * @return mixed
     */
    public function forceDelete(User $user, Visit $visit)
    {
        //
    }
}
