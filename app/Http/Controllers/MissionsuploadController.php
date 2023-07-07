<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsMissionsbauer;
use Illuminate\Http\Request;

class MissionsuploadController extends Controller
{
    public function __construct() {
        $this->middleware([IsMissionsbauer::class]);
    }

    public function index()
    {
        $missions = [];
        $path = config('ttt.missions_path');
        if (is_dir($path)) {
            $allMissions = array_diff(scandir($path), array('..', '.'));
            foreach ($allMissions as $mission) {
                $missions[] = [
                    'name' => $mission,
                    'change' => date ("d.m.Y H:i:s", filemtime($path . $mission)),
                ];
            }
        }
        return view('intern.missionupload.index', compact('missions'));
    }
}
