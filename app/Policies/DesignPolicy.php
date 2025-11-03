<?php

namespace App\Policies;

use App\Design;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DesignPolicy
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
     * @param  \App\Design  $design
     * @return mixed
     */
    public function view(User $user, Design $design)
    {
        return $user->isAdmin();
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
     * @param  \App\Design  $design
     * @return mixed
     */
    public function update(User $user, Design $design)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Design  $design
     * @return mixed
     */
    public function delete(User $user, Design $design)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Design  $design
     * @return mixed
     */
    public function restore(User $user, Design $design)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Design  $design
     * @return mixed
     */
    public function forceDelete(User $user, Design $design)
    {
        return $user->isAdmin();
    }

    public function changeActive(User $user)
    {
        return $user->isAdmin();
    }

    public function listOfColors(User $user)
    {
        return $user->isAdmin();
    }

    // public function designColor_changeActive(User $user)
    // {
    //     return $user->isAdmin();
    // }

    public function designColor_delete(User $user)
    {
        return $user->isAdmin();
    }

    public function designColor_store(User $user)
    {
        return $user->isAdmin();
    }
}
