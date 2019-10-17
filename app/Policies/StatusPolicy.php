<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    // 自能删除自己的动态
    public function destroy(User $user, Status $status) {
        return $user->id === $status->user_id;
    }
}
