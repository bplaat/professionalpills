<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalUser extends Model
{
    protected $table = 'hospital_user';

    // A hospital user can have different roles
    const ROLE_NORMAL = 0;
    const ROLE_DRIVER = 1;
    const ROLE_NURSE = 2;
    const ROLE_DOCTOR = 3;
    const ROLE_RESEARCHER = 4;
    const ROLE_IT = 5;

    protected $fillable = [
        'hospital_id',
        'user_id',
        'role'
    ];
}
