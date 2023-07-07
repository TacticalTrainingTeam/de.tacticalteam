<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsMissionsbauer;
use App\Models\MissionuploadLog;
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

    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['mission' => 'required|max:6000'],
            [
                'mission.required' => "Es muss eine PBO-Datei ausgewählt werden!",
                'mission.mimes' => 'Es dürfen nur .pbo Dateien hochgeladen werden!',
                'mission.max' => 'Die Datei darf maximal 6 MB groß sein!',
            ]
        );
        if ($request->has('missionfinal') === false) {
            return redirect()->route('missionupload.index')->withErrors('So geht das nicht! Du musst schon sagen, ob das eine spielbereite Mission ist oder nicht!');
        }
        if ($request->get('missionfinal') == 1 and $request->get('tests') != "1") {
            return redirect()->route('missionupload.index')->withErrors('Das ist eine spielbereite Mission und du hast keine Alpha- und Beta-Tests gemacht? Na so geht das aber nicht! Deine Mission kommt in den Papierkorb und machst brav deine Tests. Dann kannst du gerne wieder kommen.');
        }
        if ($request->hasFile('mission')) {
            //get filename with extension
            $filenamewithextension = $request->file('mission')->getClientOriginalName();

            if ($this->checkIfFileExists($filenamewithextension)) {
                return redirect()->route('missionupload.index')->withErrors('Die hochgeladene Datei existiert bereits! Bitte unter anderem Namen hochladen');
            }


            //get file extension
            $extension = $request->file('mission')->getClientOriginalExtension();
            if ($extension != "pbo") {
                return redirect()->route('missionupload.index')->withErrors('Die hochgeladene Datei war keine PBO-Datei!');
            }

            $newPath = config('ttt.missions_path').$filenamewithextension;
            move_uploaded_file($request->file('mission'), $newPath);

            MissionuploadLog::log($filenamewithextension);
            return redirect()->route('missionupload.index')->with('success', 'Datei '.$filenamewithextension.' wurde erfolgreich hochgeladen!');
        }
        return redirect()->route('missionupload.index')->withErrors('Keine Datei!');
    }

    /**
     * @param $file
     * @return bool
     * @author Isaac <andre.ee1996@web.de>
     */
    private function checkIfFileExists($file)
    {
        if (file_exists(config('ttt.missions_path').$file)) {
            return true;
        } else {
            return false;
        }
    }
}
