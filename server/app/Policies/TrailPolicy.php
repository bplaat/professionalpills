<?php

namespace App\Policies;

use App\Models\Hospital;
use App\Models\HospitalUser;
use App\Models\Trail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrailPolicy
{
    use HandlesAuthorization;

    // You can create a trail if you are at least a researcher in a hospital
    public function create(User $user, Hospital $hospital)
    {
        $hospitalUser = HospitalUser::where('hospital_id', $hospital->id)->where('user_id', $user->id);
        return $hospitalUser->count() == 1 && $hospitalUser->first()->role >= HospitalUser::ROLE_RESEARCHER;
    }

    // You need to be at least a researcher of the hospital of the trail to update the trail information
    public function run(User $user, Trail $trail)
    {
        return $this->update($user, $trail) && !$trail->running;
    }

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
    public function create_trail_user_form(User $user, Trail $trail)
    {
        return $this->update($user, $trail);
    }

    public function create_trail_user(User $user, Trail $trail)
    {
        return true; // %BUG

        return $this->update($user, $trail);
    }

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
