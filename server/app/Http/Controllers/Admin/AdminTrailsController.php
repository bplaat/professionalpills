<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Trail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminTrailsController extends Controller
{
    // Admin trails index route
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
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin trails index view
        return view('admin.trails.index', ['trails' => $trails]);
    }

    // Admin trails create route
    public function create(Trail $trail)
    {
        // Get all the hospitals
        $hospitals = Hospital::all();

        // Return admin trails create view
        return view('admin.trails.create', ['hospitals' => $hospitals]);
    }

    // Admin trails store route
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

        // Go to the new admin trail show page
        return redirect()->route('admin.trails.show', $trail);
    }

    // Admin trails show route
    public function show(Trail $trail)
    {
        return view('admin.trails.show', [ 'trail' => $trail ]);
    }

    // Admin trails run route
    public function run(Trail $trail)
    {
        // Update trail
        $trail->update([
            'running' => true
        ]);

        // Go to the admin trail show page
        return redirect()->route('admin.trails.show', $trail);
    }

    // Admin trails edit route
    public function edit(Trail $trail)
    {
        // Get all the hospitals
        $hospitals = Hospital::all();

        // Return admin trails edit view
        return view('admin.trails.edit', ['trail' => $trail, 'hospitals' => $hospitals]);
    }

    // Admin trails update route
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
            'limit' => $fields['limit'],
            'running' => false
        ]);

        // Go to the admin trail show page
        return redirect()->route('admin.trails.show', $trail);
    }

    // Admin trails delete route
    public function delete(Trail $trail)
    {
        // Delete trail
        $trail->delete();

        // Go to the trails index page
        return redirect()->route('admin.trails.index');
    }
}
