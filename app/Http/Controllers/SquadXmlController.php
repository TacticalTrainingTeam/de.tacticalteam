<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\SquadXml;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SquadXmlController extends Controller
{
    public function index()
    {
        /*if (User::UserIn(Roles::Offizier)) {
            // Vorerst auch nur die eigenen
            $entries = SquadXml::where('user_id', Auth::id())->get();
            //$entries = SquadXml::withTrashed()->get();
        } else {
            $entries = SquadXml::where('user_id', Auth::id())->get();
        }*/
        $entries = SquadXml::where('user_id', Auth::id())->get();
        $locked = false;
        if (count($entries) > 0) {
            $locked = true;
        }

        $login_url_params = [
            'openid.ns'         => 'http://specs.openid.net/auth/2.0',
            'openid.mode'       => 'checkid_setup',
            'openid.return_to'  =>  url()->route('squadxml.steam'),
            'openid.realm'      => (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'],
            'openid.identity'   => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select',
        ];
        $steamUrl = 'https://steamcommunity.com/openid/login'.'?'.http_build_query($login_url_params, '', '&');


        return view('intern.squadxml.index', compact('entries', 'locked', 'steamUrl'));
    }

    public function steam(Request $request)
    {
        if (Auth::user()->steam_id != null) {
            return redirect()->route('squadxml.index')->withErrors('Du hast keine Berechtigung für diese Steam-Aktion!');
        }
        $parameters = $request->query->all();

        $params = [
            'openid.assoc_handle' => $parameters['openid_assoc_handle'],
            'openid.signed'       => $parameters['openid_signed'],
            'openid.sig'          => $parameters['openid_sig'],
            'openid.ns'           => 'http://specs.openid.net/auth/2.0',
            'openid.mode'         => 'check_authentication',
        ];

        $signed = explode(',', $parameters['openid_signed']);

        foreach ($signed as $item) {
            $val = $parameters['openid_'.str_replace('.', '_', $item)];
            $params['openid.'.$item] = stripslashes($val);
        }

        $data = http_build_query($params);
        //data prep
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Accept-language: en\r\n".
                    "Content-type: application/x-www-form-urlencoded\r\n".
                    'Content-Length: '.strlen($data)."\r\n",
                'content' => $data,
            ],
        ]);

        //get the data
        $result = file_get_contents('https://steamcommunity.com/openid/login', false, $context);

        if(preg_match("#is_valid\s*:\s*true#i", $result)){
            preg_match('#^https://steamcommunity.com/openid/id/([0-9]{17,25})#', $parameters['openid_claimed_id'], $matches);
            $steamID64 = is_numeric($matches[1]) ? $matches[1] : 0;

            /** @var User $user */
            $user = User::where('id', Auth::id())->firstOrFail();
            $user->steam_id = $steamID64;
            $user->save();
            return redirect()->route('squadxml.index')->with('success', 'Die SteamID wurde erfolgreich gefunden und deinem User hinterlegt.');
        }else{
            return redirect()->route('squadxml.index')->withErrors('Die Steam ID konnte nicht validiert werden.');
        }
    }

    public function store(Request $request)
    {
        $entries = SquadXml::where('user_id', Auth::id())->get();
        if (count($entries) > 0) {
            return redirect()->route('squadxml.index')->withErrors(['Du versuchst einen Eintrag zu erstellen, aber du hast bereits einen. Also Nein!']);
        }
        $validatedData = $request->validate([
            'steam' => ['digits:17', 'required'],
            'username' => ['required', 'min:1', 'max:50'],
        ]);

        try {
            $xml = new SquadXml();
            $xml->user_id = Auth::id();
            $xml->type = "NORMAL";
            $xml->steam_id = $validatedData['steam'];
            $xml->name = $validatedData['username'];
            $xml->remark = User::getTTTRank();
            $xml->saveOrFail();
            return redirect()->route('squadxml.index')->with('success', 'Dein SquadXML-Eintrag wurde erfolgreich erstellt.');
        } catch (\Throwable $exception) {
            return redirect()->route('squadxml.index')->withErrors(['Es ist ein Fehler beim Speichern aufgetreten.']);
        }
    }
}
