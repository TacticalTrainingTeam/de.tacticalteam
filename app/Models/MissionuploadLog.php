<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MissionuploadLog extends Model
{
    use HasFactory;

    protected $table = 'missionsupload_log';

    public static function log(string $mission)
    {
        $log = new MissionuploadLog();
        $log->mission = $mission;
        $log->user_id = Auth::id();
        $log->save();
    }
}
