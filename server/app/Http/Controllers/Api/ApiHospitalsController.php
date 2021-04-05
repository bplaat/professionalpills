<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;

class ApiHospitalsController extends Controller
{
    // Api hospitals index route
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
            ->paginate(config('pagination.api.limit'));

        // Return hospitals paginated as json
        return $hospitals;
    }

    // Api hospitals show route
    public function show(Hospital $hospital)
    {
        // Activate hospital trails and users
        $hospital->trails;
        $hospital->users;

        // Return hospital as json
        return $hospital;
    }
}
