<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    // 只能修改自身信息
    public function update(User $currenUser, User $user) {
        return $currenUser->id === $user->id;
    }

    // 只有管理员可以删除用户
    public function destroy(User $currenUser, User $user) {
        return $currenUser->is_admin && $currenUser->id !== $user->id;
    }

    // 不能关注自己
    public function follow(User $currentUser, User $user) {
        return $currentUser->id !== $user->id;
    }
}
