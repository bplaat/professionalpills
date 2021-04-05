<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Trail;

class ApiHospitalTrailsController extends Controller
{
    // Api hospital trails index route
    public function index(Hospital $hospital)
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $hospitalTrails = Trail::searchCollection($hospital->trails, $query);
        } else {
            $hospitalTrails = $hospital->trails;
        }
        $hospitalTrails = $hospitalTrails->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.api.limit'))->withQueryString();

        // Return hospital trails paginated as json
        return $hospitalTrails;
    }

    // Api hospital trails show route
    public function show(Hospital $hospital, Trail $trail)
    {
        // Activate trail users
        $trail->users;

        // Return trail as json
        return $trail;
    }
}
