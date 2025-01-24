<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitchToken extends Model
{
    use HasFactory;

    protected $table = 'twitch_token';

    public $timestamps = false;
}
