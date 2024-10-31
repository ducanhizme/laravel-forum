<?php

namespace App\Policies;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Discussion $discussion): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Discussion $discussion): bool
    {
    }

    public function delete(User $user, Discussion $discussion): bool
    {
    }

    public function restore(User $user, Discussion $discussion): bool
    {
    }

    public function forceDelete(User $user, Discussion $discussion): bool
    {
    }
}
