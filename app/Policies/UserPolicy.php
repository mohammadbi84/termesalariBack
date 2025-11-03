<?php

namespace App\Policies;

use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // public function before($user, $ability)
    // {
    //     return $user->isAdmin();
    // }
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
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user)
    {
        // dd($model);
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
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user)
    {  
        return $user->id === Auth::id();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
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
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->isAdmin();
    }

    public function profile(User $user)
    {
        return $user->id === Auth::id();
    }

    public function myOrders(User $user)
    {
        return $user->id === Auth::id();
    }

    public function myOrder(User $user)
    {
        return $user->id === Auth::id();
    }

    public function myPayments(User $user)
    {
        return $user->id === Auth::id();
    }

    public function changePassword(User $user)
    {
        return $user->id === Auth::id();
    }

    public function updatePassword(User $user)
    {
        return $user->id === Auth::id();
    }

    public function favorites(User $user)
    {
        return $user->id === Auth::id();
    }

    public function comments(User $user)
    {
        return $user->id === Auth::id();
    }

    public function deleteComment(User $user)
    {
        return $user->id === Auth::id();
    }

    public function deleteComments(User $user)
    {
        return $user->id === Auth::id();
    }

    public function recipients(User $user)
    {
        return $user->id === Auth::id();
    }

    public function messages(User $user)
    {
        return $user->id === Auth::id();
    }

    public function messageStore(User $user)
    {
        return $user->id === Auth::id();
    }

    public function messageDetail(User $user)
    {
        return $user->id === Auth::id();
    }

    public function messageRead(User $user)
    {
        return $user->id === Auth::id();
    }

    public function saveAnswer(User $user)
    {
        return $user->id === Auth::id();
    }

    public function delConversation(User $user)
    {
        return $user->id === Auth::id();
    }

    public function delMessage(User $user)
    {
        return $user->id === Auth::id();
    }

    public function changeImage(User $user)
    {
        return $user->id === Auth::id();
    }

    public function changeStatus(User $user)
    {
        return $user->isAdmin();
    }

    public function changeStatusGroup(User $user)
    {
        return $user->isAdmin();
    }

    public function saveChange(User $user)
    {
        return $user->isAdmin();
    }

    public function adminProfile(User $user)
    {
        return $user->isAdmin();
    }

    public function adminProfileStore(User $user)
    {
        return $user->isAdmin();
    }

    public function adminChangeImage(User $user)
    {
        return $user->isAdmin();
    }

    public function adminChangePassword(User $user)
    {
        return $user->isAdmin();
    }

    public function dashboard(User $user)
    {
        return $user->isAdmin();
    }

    public function export(User $user)
    {
        return $user->isAdmin();
    }




}//END
