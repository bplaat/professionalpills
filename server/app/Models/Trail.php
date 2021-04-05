<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Trail extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id',
        'name',
        'description',
        'limit',
        'running'
    ];

    protected $casts = [
        'running' => 'boolean'
    ];

    // A trail belongs to a hospital
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    // A trail belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('enrolled');
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%');
    }

    // Search collection by a query
    public static function searchCollection($collection, $query)
    {
        return $collection->filter(function ($boat) use ($query) {
            return Str::contains(strtolower($boat->name), strtolower($query)) ||
                Str::contains(strtolower($boat->description), strtolower($query));
        });
    }
}
