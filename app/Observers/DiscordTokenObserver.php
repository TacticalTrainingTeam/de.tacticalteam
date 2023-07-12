<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jakyeru\Larascord\Models\DiscordAccessToken;

class DiscordTokenObserver extends AbstractObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(DiscordAccessToken $discordAccessToken): void
    {
        try {
            $user = User::where('id', $discordAccessToken->user_id)->firstOrFail();
            $this->setRank($user);
        } catch (ModelNotFoundException $exception) {

        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(DiscordAccessToken $discordAccessToken): void
    {
        try {
            $user = User::where('id', $discordAccessToken->user_id)->firstOrFail();
            $this->setRank($user);
        } catch (ModelNotFoundException $exception) {

        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(DiscordAccessToken $discordAccessToken): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(DiscordAccessToken $discordAccessToken): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(DiscordAccessToken $discordAccessToken): void
    {
        //
    }
}
