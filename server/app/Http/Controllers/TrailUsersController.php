<?php

namespace App\Http\Controllers;

use App\Models\Trail;
use App\Models\TrailUser;
use App\Models\User;
use Illuminate\Http\Request;

class TrailUsersController extends Controller
{
    // Trail users store route
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
        return redirect()->route('trails.show', $trail);
    }

    // Trail users delete route
    public function delete(Request $request, Trail $trail, User $user)
    {
        // Validate input
        if ($trail->running) {
            abort(400);
        }

        // Delete trail user connection
        $trail->users()->detach($user);

        // Go back to the trail page
        return redirect()->route('trails.show', $trail);
    }
}
