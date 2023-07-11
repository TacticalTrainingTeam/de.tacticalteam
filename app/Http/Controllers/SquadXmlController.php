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
        return view('intern.squadxml.index', compact('entries', 'locked'));
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
            $xml->remark = Auth::user()->rank;
            $xml->saveOrFail();
            return redirect()->route('squadxml.index')->with('success', 'Dein SquadXML-Eintrag wurde erfolgreich erstellt.');
        } catch (\Throwable $exception) {
            return redirect()->route('squadxml.index')->withErrors(['Es ist ein Fehler beim Speichern aufgetreten.']);
        }
    }
}
