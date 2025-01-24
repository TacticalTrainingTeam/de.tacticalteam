<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscordAccessTokens extends Model
{
    use HasFactory;

    protected $table = 'discord_access_tokens';
}
