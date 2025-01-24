<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;

class AddDiscordGuildNick extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-discord-guild-nick';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alle X Stunden werden für alle aktiven User der Discord TTT-Nick gezogen.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('active', 1)->get();
        foreach ($users as $user) {
            $dateTime = new Carbon();
            $dateTime->modify('-24 hours');
            if ($user->updated_at < $dateTime) {
                try {
                    $guildMember = $user->getGuildMember(config('ttt.guild_id'));
                    if ($guildMember->nick != null) {
                        $user->ttt_nick = $guildMember->nick;
                        $user->save();
                    }
                } catch (RequestException $e) {
                    \Log::info($e->getMessage());
                }
            }
        }
    }
}
