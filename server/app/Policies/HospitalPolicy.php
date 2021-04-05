<?php

namespace App\Policies;

use App\Models\Hospital;
use App\Models\HospitalUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HospitalPolicy
{
    use HandlesAuthorization;

    // You need to be a IT to update the hospital information
    public function update(User $user, Hospital $hospital)
    {
        $hospitalUser = HospitalUser::where('hospital_id', $hospital->id)->where('user_id', $user->id);
        return $hospitalUser->count() == 1 && $hospitalUser->first()->role == HospitalUser::ROLE_IT;
    }

    public function delete(User $user, Hospital $hospital)
    {
        return $this->update($user, $hospital);
    }

    // Hospital user connection
    public function view_hospital_user(User $user, Hospital $hospital)
    {
        return $this->update($user, $hospital);
    }

    public function create_hospital_user(User $user, Hospital $hospital)
    {
        return $this->update($user, $hospital);
    }

    public function edit_hospital_user(User $user, Hospital $hospital)
    {
        return $this->update($user, $hospital);
    }

    public function delete_hospital_user(User $user, Hospital $hospital)
    {
        return $this->update($user, $hospital);
    }
}
