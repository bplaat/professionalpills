<?php

namespace App\Policies;

use App\Models\HospitalUser;
use App\Models\Trail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrailPolicy
{
    use HandlesAuthorization;

    // You need to be at least a researcher of the hospital of the trail to update the trail information
    public function update(User $user, Trail $trail)
    {
        $hospitalUser = HospitalUser::where('hospital_id', $trail->hospital->id)->where('user_id', $user->id);
        return $hospitalUser->count() == 1 && $hospitalUser->first()->role >= HospitalUser::ROLE_RESEARCHER;
    }

    public function delete(User $user, Trail $trail)
    {
        return $this->update($user, $trail);
    }

    // Trail user connection
    // %BUG
    public function create_trail_user_form(User $user, Trail $trail)
    {
        return $this->update($user, $trail);
    }

    public function create_trail_user(User $user, Trail $trail)
    {
        return true; // %BUG

        return $this->update($user, $trail);
    }

    // %BUG
    public function delete_trail_user_form(User $user, Trail $trail)
    {
        return $this->update($user, $trail);
    }

    public function delete_trail_user(User $user, Trail $trail)
    {
        return true; // %BUG

        return $this->update($user, $trail);
    }
}
