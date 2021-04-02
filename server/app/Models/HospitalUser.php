<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalUser extends Model
{
    protected $table = 'hospital_user';

    // A hospital user can have different roles
    const ROLE_NORMAL = 0;
    const ROLE_MEDIC = 1;
    const ROLE_LOGISTIC = 2;
    const ROLE_RESEARCHER = 3;
    const ROLE_IT = 4;

    protected $fillable = [
        'hospital_id',
        'user_id',
        'role'
    ];
}
