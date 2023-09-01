<?php

namespace App\Http\Controllers;

use App\Models\TwitchToken;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TwitchController extends Controller
{
    public function index()
    {
        $streams = $this->getAllStreams();
        return view('twitch.start', compact('streams'));
    }

    public function getAllStreams()
    {
        $client = new Client();
        $headers = [
            'Client-Id' => config('ttt.twitch_client_id'),
            'Authorization' => 'Bearer ' . $this->getBearerToken(),
        ];
        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://api.twitch.tv/helix/streams?type=live&language=de&first=100&game_id=31750', $headers);
        $res = $client->sendAsync($request)->wait();
        $liveStreams = json_decode($res->getBody())->data;
        $tttStreams = [];
        foreach ($liveStreams as $stream) {
            if (str_contains($stream->title, 'tacticalteam.de') or str_contains($stream->title, 'Tactical Training Team')) {
                $tttStreams[] = $stream;
            }
        }
        return $tttStreams;
    }

    private function getBearerToken()
    {
        $tokens = TwitchToken::all();
        if (count($tokens) == 0) {
            return $this->generateAndSetToken();
        } else {
            $token = $tokens->firstOrFail();
            $actDateTime = new \DateTime();
            if ($actDateTime <= $token->valid_to) {
                $token->delete();
                return $this->generateAndSetToken();
            }
            return $token->baerer;
        }
    }

    private function generateAndSetToken()
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = [
            'form_params' => [
                'client_id' => config('ttt.twitch_client_id'),
                'client_secret' => config('ttt.twitch_client_secret'),
                'grant_type' => 'client_credentials'
            ]];
        $request = new \GuzzleHttp\Psr7\Request('POST', 'https://id.twitch.tv/oauth2/token', $headers);
        $res = $client->sendAsync($request, $options)->wait();
        $result = json_decode($res->getBody());
        $newToken = new TwitchToken();
        $newToken->baerer = $result->access_token;
        $dateTime = new \DateTime();
        $seconds = $result->expires_in;
        $seconds = $seconds - 60;
        $dateTime->add(new \DateInterval('PT' . $seconds . "S"));
        $newToken->valid_to = $dateTime;
        $newToken->saveOrFail();

        return $newToken->baerer;
    }
}
