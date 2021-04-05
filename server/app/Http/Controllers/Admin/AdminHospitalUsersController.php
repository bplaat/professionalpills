<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalUser;
use App\Models\User;
use Illuminate\Http\Request;

class AdminHospitalUsersController extends Controller
{
    // Admin hospital users store route
    public function store(Request $request, Hospital $hospital)
    {
        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|integer|digits_between:' . HospitalUser::ROLE_DRIVER . ',' . HospitalUser::ROLE_IT
        ]);

        // Create hospital user connection
        $hospital->users()->attach($fields['user_id'], [
            'role' => $fields['role']
        ]);

        // Go back to the hospital page
        return redirect()->route('admin.hospitals.show', $hospital);
    }

    // Admin hospital users update route
    public function update(Request $request, Hospital $hospital, User $user)
    {
        // Validate input
        $fields = $request->validate([
            'role' => 'required|integer|digits_between:' . HospitalUser::ROLE_DRIVER . ',' . HospitalUser::ROLE_IT
        ]);

        // Update hospital user connection
        $hospital->users()->updateExistingPivot($user, [
            'role' => $fields['role']
        ]);

        // Go back to the hospital page
        return redirect()->route('admin.hospitals.show', $hospital);
    }

    // Admin hospital users delete route
    public function delete(Request $request, Hospital $hospital, User $user)
    {
        // Delete hospital user connection
        $hospital->users()->detach($user);

        // Go back to the hospital page
        return redirect()->route('admin.hospitals.show', $hospital);
    }
}
