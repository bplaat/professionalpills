<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrailUser extends Model
{
    protected $table = 'trail_user';

    protected $fillable = [
        'trail_id',
        'user_id',
        'enrolled'
    ];

    protected $casts = [
        'enrolled' => 'boolean'
    ];
}
