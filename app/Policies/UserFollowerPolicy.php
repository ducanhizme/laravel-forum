<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserFollowerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, UserFollower $userFollower): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, UserFollower $userFollower): bool
    {
    }

    public function delete(User $user, UserFollower $userFollower): bool
    {
    }

    public function restore(User $user, UserFollower $userFollower): bool
    {
    }

    public function forceDelete(User $user, UserFollower $userFollower): bool
    {
    }
}
