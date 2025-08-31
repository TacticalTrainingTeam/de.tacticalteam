<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsOffizier;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function missionsteilnahme()
    {
        try {
            $pdo    = new \PDO('mysql:host=' . config('ttt.stasi_host') . ';dbname=' . config('ttt.stasi_db') . ';charset=utf8', config('ttt.stasi_user'), config('ttt.stasi_password'));
            $select = "SELECT s1.UserId, s2.CalendarSlotId, u.name, n.title, s2.TimeOfSelectingSlot FROM specslot_selectedslots AS s2 INNER JOIN
                (SELECT s1.UserId, MAX(s1.CalendarUserSlotId) AS cusi FROM specslot_selectedslots AS s1 WHERE s1.SlotIndex NOT IN (-1) AND EXISTS (SELECT * FROM users_roles AS ur WHERE ur.uid = s1.UserId AND ur.rid IN (38, 29, 31, 12, 36, 14, 6, 34, 51, 44, 5, 53)) GROUP BY s1.UserId ORDER BY cusi DESC) AS s1 ON s1.cusi = s2.CalendarUserSlotId
                LEFT JOIN users AS u ON u.uid = s1.UserId
                LEFT JOIN node AS n ON s2.CalendarSlotId = n.nid";
            $result = $pdo->query($select)->fetchAll();
        } catch (\Exception $exception) {
            $result = [];
        }
        return view('intern.offizier.missionteilnahme', compact('result'));
    }

    public function uebersicht()
    {
        $this->middleware = [IsOffizier::class];

        $allUsers = User::all();
        $usersArray = [];
        foreach ($allUsers as $user) {
            $tmpArray = [];
            $tmpArray['id'] = $user->id;
            $tmpArray['username'] = $user->username;
            $tmpArray['globalName'] = $user->global_name;
            $tmpArray['ttt_nick'] = $user->ttt_nick;
            $tmpArray['steam'] = $user->steam_id;
            $tmpArray['active'] = $user->active;
            $tmpArray['erstellt'] = $user->created_at->format('d.m.Y');
            $tmpArray['roles'] = implode(', ', User::getRawRoles($user->roles, true));
            $usersArray[] = $tmpArray;
        }
        return view('intern.offizier.users', compact('usersArray'));
    }
}
