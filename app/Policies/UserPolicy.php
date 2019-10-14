<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $currenUser, User $user) {
        return $currenUser->id === $user->id;
    }

    public function destroy(User $currenUser, User $user) {
        return $currenUser->is_admin && $currenUser->id !== $user->id;
    }
}
