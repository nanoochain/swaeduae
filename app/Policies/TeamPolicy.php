<?php
namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function view(User \$user, Team \$team)
    {
        return \$team->members()->where('user_id', \$user->id)->exists();
    }

    public function update(User \$user, Team \$team)
    {
        return \$team->owner_id === \$user->id;
    }
}
