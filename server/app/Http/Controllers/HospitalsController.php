<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\HospitalUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class HospitalsController extends Controller
{
    // Hospitals index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $hospitals = Hospital::search($query)->get();
        } else {
            $hospitals = Hospital::all();
        }
        $hospitals = $hospitals->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return hospitals index view
        return view('hospitals.index', ['hospitals' => $hospitals]);
    }

    // Hospitals store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'address' => 'required|min:2|max:255',
            'postcode' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255'
        ]);

        // Create hospital
        $hospital = Hospital::create([
            'name' => $fields['name'],
            'address' => $fields['address'],
            'postcode' => $fields['postcode'],
            'city' => $fields['city'],
            'country' => $fields['country']
        ]);

        // Go to the new hospital show page
        return redirect()->route('hospitals.show', $hospital);
    }

    // Hospitals show route
    public function show(Hospital $hospital)
    {
        // Select hospital information
        $hospitalTrails = $hospital->trails->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('running')->paginate(config('pagination.web.limit'))->withQueryString();

        $hospitalUsers = $hospital->users->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('pivot.role')->paginate(config('pagination.web.limit'))->withQueryString();
        $users = User::all()->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE);

        // Return hospital show view
        return view('hospitals.show', [
            'hospital' => $hospital,

            'hospitalTrails' => $hospitalTrails,

            'hospitalUsers' => $hospitalUsers,
            'users' => $users
        ]);
    }

    // Hospitals edit route
    public function edit(Hospital $hospital)
    {
        return view('hospitals.edit', ['hospital' => $hospital]);
    }

    // Hospitals update route
    public function update(Request $request, Hospital $hospital)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'address' => 'required|min:2|max:255',
            'postcode' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255'
        ]);

        // Update hospital
        $hospital->update([
            'name' => $fields['name'],
            'address' => $fields['address'],
            'postcode' => $fields['postcode'],
            'city' => $fields['city'],
            'country' => $fields['country']
        ]);

        // Go to the hospital show page
        return redirect()->route('hospitals.show', $hospital);
    }

    // Hospitals delete route
    public function delete(Hospital $hospital)
    {
        // Delete hospital
        $hospital->delete();

        // Go to the hospitals index page
        return redirect()->route('hospitals.index');
    }
}
