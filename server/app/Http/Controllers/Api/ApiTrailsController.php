<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trail;

class ApiTrailsController extends Controller
{
    // Api trails index route
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
            ->paginate(config('pagination.api.limit'));

        // Return trails paginated as json
        return $trails;
    }

    // Api trails show route
    public function show(Trail $trail)
    {
        // Activate trail users
        $trail->users;

        // Return trail as json
        return $trail;
    }
}
