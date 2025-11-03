<?php

namespace App\Policies;

use App\Slideshow;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SlideshowPolicy
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
     * @param  \App\Slideshow  $slideshow
     * @return mixed
     */
    public function view(User $user, Slideshow $slideshow)
    {
        //
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
     * @param  \App\Slideshow  $slideshow
     * @return mixed
     */
    public function update(User $user, Slideshow $slideshow)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Slideshow  $slideshow
     * @return mixed
     */
    public function delete(User $user, Slideshow $slideshow)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Slideshow  $slideshow
     * @return mixed
     */
    public function restore(User $user, Slideshow $slideshow)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Slideshow  $slideshow
     * @return mixed
     */
    public function forceDelete(User $user, Slideshow $slideshow)
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
}
