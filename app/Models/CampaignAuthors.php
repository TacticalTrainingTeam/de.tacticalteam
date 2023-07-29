<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignAuthors extends Model
{
    use SoftDeletes;

    protected $table = 'campaigns_authors';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'campaign_id',
    ];

    public function user(): User
    {
        return $this->belongsTo(User::class)->firstOrFail();
    }
}
