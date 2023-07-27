<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        '24_hour_notification',
        '3_hour_notification',
    ];
}
