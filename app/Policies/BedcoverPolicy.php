<?php

namespace App\Policies;

use App\Bedcover;
use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class BedcoverPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Bedcover  $bedcover
     * @return mixed
     */
    public function view(User $user, Bedcover $bedcover)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Bedcover  $bedcover
     * @return mixed
     */
    public function update(User $user, Bedcover $bedcover)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Bedcover  $bedcover
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Bedcover  $bedcover
     * @return mixed
     */
    public function restore(User $user, Bedcover $bedcover)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Bedcover  $bedcover
     * @return mixed
     */
    public function forceDelete(User $user, Bedcover $bedcover)
    {
        return $user->isAdmin();
    }

    public function changeVisibility(User $user)
    {
        return $user->isAdmin();
    }

    public function changeVisibilityGroup(User $user)
    {
        return $user->isAdmin();
    }

    public function storeIndex(User $user)
    {
        return true;
    }

    public function duplicate(User $user)
    {
        return $user->isAdmin();
    }

}
