<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trail;
use App\Models\User;
use Illuminate\Http\Request;

class ApiTrailUsersController extends Controller
{
    // Api trail users index route
    public function index(Trail $trail)
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $trailUsers = User::searchCollection($trail->users, $query);
        } else {
            $trailUsers = $trail->users;
        }
        $trailUsers = $trailUsers->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.api.limit'))->withQueryString();

        // Return trail users paginated as json
        return $trailUsers;
    }

    // Api trail users store route
    public function store(Request $request, Trail $trail)
    {
        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        if ($trail->running) {
            abort(400);
        }
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Create trail user connection
        $trail->users()->attach($fields['user_id'], [
            'enrolled' => false
        ]);

        // Show success message
        return [
            'message' => 'You added a user to this trail successfully'
        ];
    }

    // Api trail users delete route
    public function delete(Request $request, Trail $trail, User $user)
    {
        // Validate input
        if ($trail->running) {
            abort(400);
        }

        // Delete trail user connection
        $trail->users()->detach($user);

        // Show success message
        return [
            'message' => 'You deleted a user from this trail successfully'
        ];
    }
}
