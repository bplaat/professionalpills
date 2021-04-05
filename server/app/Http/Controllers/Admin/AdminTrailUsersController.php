<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trail;
use App\Models\TrailUser;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTrailUsersController extends Controller
{
    // Admin trail users store route
    public function store(Request $request, Trail $trail)
    {
        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        if ($trail->running) {
            abort(400);
        }

        // Create trail user connection
        $trail->users()->attach($fields['user_id'], [
            'enrolled' => false
        ]);

        // Go back to the trail page
        return redirect()->route('admin.trails.show', $trail);
    }

    // Admin trail users delete route
    public function delete(Request $request, Trail $trail, User $user)
    {
        // Validate input
        if ($trail->running) {
            abort(400);
        }

        // Delete trail user connection
        $trail->users()->detach($user);

        // Go back to the trail page
        return redirect()->route('admin.trails.show', $trail);
    }
}
