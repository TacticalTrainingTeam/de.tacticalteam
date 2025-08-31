<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class SyncDiscordRoles
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        // Ensure the user model provides the required method (from InteractsWithDiscord)
        if (!method_exists($user, 'getGuildMember')) {
            return; // Not a Discord-authenticated user
        }

        // Collect guild ids to sync roles from
        $guildIds = [];
        $guildsFromConfig = (array) config('larascord.guilds', []);
        $guildRolesFromConfig = (array) array_keys((array) config('larascord.guild_roles', []));
        foreach ($guildsFromConfig as $gid) { $guildIds[] = (string) $gid; }
        foreach ($guildRolesFromConfig as $gid) { $guildIds[] = (string) $gid; }
        $guildIds = array_values(array_unique($guildIds));

        if (empty($guildIds)) {
            return; // nothing to sync
        }

        $rolesByGuild = [];

        foreach ($guildIds as $guildId) {
            try {
                // Fetch GuildMember (requires scopes: guilds & guilds.members.read)
                $member = $user->getGuildMember($guildId);
                if ($member) {
                    $rolesByGuild[$guildId] = $member->roles ?? [];
                }
            } catch (\Throwable $e) {
                // If missing scopes or not in guild, skip but log
                Log::warning('[PostLoginRoleSync] Failed to fetch roles for guild '.$guildId.': '.$e->getMessage());
            }
        }

        if (!empty($rolesByGuild)) {
            // Persist to user roles JSON exactly as expected by the app
            $user->roles = $rolesByGuild;
            try {
                $user->save();
            } catch (\Throwable $e) {
                Log::error('[PostLoginRoleSync] Failed to save roles for user '.$user->id.': '.$e->getMessage());
            }
        }
    }
}
