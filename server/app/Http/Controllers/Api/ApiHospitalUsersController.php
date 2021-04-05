<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\User;

class ApiHospitalUsersController extends Controller
{
    // Api hospital users index route
    public function index(Hospital $hospital)
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $hospitalUsers = User::searchCollection($hospital->users, $query);
        } else {
            $hospitalUsers = $hospital->users;
        }
        $hospitalUsers = $hospitalUsers->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.api.limit'))->withQueryString();

        // Return hospital users paginated as json
        return $hospitalUsers;
    }

    // Api hospital users show route
    public function show(Hospital $hospital, User $user)
    {
        // Return user as json
        return $user;
    }
}
