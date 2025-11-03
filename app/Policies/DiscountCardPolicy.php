<?php

namespace App\Policies;

use App\DiscountCard;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountCardPolicy
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
     * @param  \App\DiscountCard  $discountCard
     * @return mixed
     */
    public function view(User $user, DiscountCard $discountCard)
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
     * @param  \App\DiscountCard  $discountCard
     * @return mixed
     */
    public function update(User $user, DiscountCard $discountCard)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\DiscountCard  $discountCard
     * @return mixed
     */
    public function delete(User $user, DiscountCard $discountCard)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\DiscountCard  $discountCard
     * @return mixed
     */
    public function restore(User $user, DiscountCard $discountCard)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\DiscountCard  $discountCard
     * @return mixed
     */
    public function forceDelete(User $user, DiscountCard $discountCard)
    {
        //
    }

    public function deleteGroup(User $user)
    {
        return $user->isAdmin();
    }

    public function changeIsGifted(User $user)
    {
        return $user->isAdmin();
    }

    public function changeIsGiftedGroup(User $user)
    {
        return $user->isAdmin();
    }
}
