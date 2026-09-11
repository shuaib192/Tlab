<?php

namespace App\Policies;

use App\Models\ChildProfile;
use App\Models\User;

class ChildProfilePolicy
{
    public function view(User $user, ChildProfile $child): bool
    {
        if (in_array($user->role, ['super_admin', 'admin'])) {
            return true;
        }

        if ($child->user_id === $user->id) {
            return true;
        }

        return (int) session('active_child_id') === (int) $child->id;
    }
}
