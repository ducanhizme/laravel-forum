<?php

namespace App\Policies;

use App\Models\Votable;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UpvotablePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Votable $upvotable): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Votable $upvotable): bool
    {
    }

    public function delete(User $user, Votable $upvotable): bool
    {
    }

    public function restore(User $user, Votable $upvotable): bool
    {
    }

    public function forceDelete(User $user, Votable $upvotable): bool
    {
    }
}
