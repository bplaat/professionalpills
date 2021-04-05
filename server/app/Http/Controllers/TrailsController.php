<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\Trail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TrailsController extends Controller
{
    // Trails index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $trails = Trail::search($query)->get();
        } else {
            $trails = Trail::all();
        }
        $trails = $trails->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('running')->paginate(config('pagination.web.limit'))->withQueryString();

        // Return trails index view
        return view('trails.index', ['trails' => $trails]);
    }

    // Trails store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'hospital_id' => 'required|integer|exists:hospitals,id',
            'name' => 'required|min:2|max:48',
            'description' => 'nullable',
            'limit' => 'required|integer|min:1|max:1000'
        ]);

        // Create trail
        $trail = Trail::create([
            'hospital_id' => $fields['hospital_id'],
            'name' => $fields['name'],
            'description' => $fields['description'],
            'limit' => $fields['limit'],
            'running' => false
        ]);

        // Go to the new trail show page
        return redirect()->route('trails.show', $trail);
    }

    // Trails show route
    public function show(Trail $trail)
    {
        // Select trail information
        $trailUsers = $trail->users->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('pivot.enrolled')->paginate(config('pagination.web.limit'))->withQueryString();
        $users = User::all()->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE);

        // Return trail show view
        return view('trails.show', [
            'trail' => $trail,

            'trailUsers' => $trailUsers,
            'users' => $users
        ]);
    }

    // Trails run route
    public function run(Trail $trail)
    {
        // Update trail
        $trail->update([
            'running' => true
        ]);

        // enrol users until limit
        $i = 0;
        $enrolled = true;
        foreach ($trail->users as $user) {
            if ($i == $trail->limit) {
                $enrolled = false;
            }

            $trail->users()->updateExistingPivot($user, [
                'enrolled' => $enrolled
            ]);

            $i++;
        }

        // Go to the trail show page
        return redirect()->route('trails.show', $trail);
    }

    // Trails edit route
    public function edit(Trail $trail)
    {
        return view('trails.edit', ['trail' => $trail]);
    }

    // Trails update route
    public function update(Request $request, Trail $trail)
    {
        // Validate input
        $fields = $request->validate([
            'hospital_id' => 'required|integer|exists:hospitals,id',
            'name' => 'required|min:2|max:48',
            'description' => 'nullable',
            'limit' => 'required|integer|min:1|max:1000'
        ]);

        // Update trail
        $trail->update([
            'hospital_id' => $fields['hospital_id'],
            'name' => $fields['name'],
            'description' => $fields['description'],
            'limit' => $fields['limit']
        ]);

        // Go to the trail show page
        return redirect()->route('trails.show', $trail);
    }

    // Trails delete route
    public function delete(Trail $trail)
    {
        // Delete trail
        $trail->delete();

        // Go to the trails index page
        return redirect()->route('trails.index');
    }
}
