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
        if ($path && !str_ends_with($path, DIRECTORY_SEPARATOR) && !str_ends_with($path, '/')) {
            $path .= DIRECTORY_SEPARATOR;
        }
        if ($path && is_dir($path)) {
            $allMissions = array_diff(scandir($path), array('..', '.'));
            foreach ($allMissions as $mission) {
                $fullPath = $path . $mission;
                $mtime = @filemtime($fullPath);

                $missions[] = [
                    'name' => $mission,
                    'change' => $mtime ? date("d.m.Y H:i:s", $mtime) : 'N/A',
                    'mtime' => $mtime ?: 0,
                ];
            }
        }
        return view('intern.missionupload.index', compact('missions'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['mission' => 'required|max:20000'],
            [
                'mission.required' => "Es muss eine PBO-Datei ausgewählt werden!",
                'mission.mimes' => 'Es dürfen nur .pbo Dateien hochgeladen werden!',
                'mission.max' => 'Die Datei darf maximal 20 MB groß sein!',
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

            $newPath = config('ttt.missions_path');
            if ($newPath && !str_ends_with($newPath, DIRECTORY_SEPARATOR) && !str_ends_with($newPath, '/')) {
                $newPath .= DIRECTORY_SEPARATOR;
            }
            $newPath .= $filenamewithextension;
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
        $path = config('ttt.missions_path');
        if ($path && !str_ends_with($path, DIRECTORY_SEPARATOR) && !str_ends_with($path, '/')) {
            $path .= DIRECTORY_SEPARATOR;
        }
        $path .= $file;
        clearstatcache(true, $path);
        if (@file_exists($path)) {
            return true;
        } else {
            return false;
        }
    }
}
