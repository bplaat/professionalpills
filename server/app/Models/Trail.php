<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(User::class);
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%');
    }
}
