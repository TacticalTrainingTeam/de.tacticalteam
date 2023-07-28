<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class OffizierController extends Controller
{
    public function userstatus(Request $request, $userid)
    {
        $user = User::where('id', $userid)->firstOrFail();
        return view('intern.offizier.userstatus', compact('user'));
    }

    public function store(Request $request)
    {
        if ($request->has('userid') === false) {
            return redirect()->back()->withErrors('UserID nicht gefunden. Bitte an Isaac wenden!');
        }
        if (User::UserIn(Roles::Offizier, $request->get('userid')) === true) {
            return redirect()->route('offizier.user')->withErrors('Es können keine Offiziere gesperrt werden!');
        }
        $user = User::where('id', $request->get('userid'))->firstOrFail();
        if ($user->active === 1) {
            $user->active = 0;
            $user->saveOrFail();
            return redirect()->route('offizier.user')->with('success', 'Der User ' . User::getUsername($user) . ' wurde erfolgreich gesperrt.');
        } elseif ($user->active === 0) {
            $user->active = 1;
            $user->saveOrFail();
            return redirect()->route('offizier.user')->with('success', 'Der User ' . User::getUsername($user) . ' wurde erfolgreich aktiviert.');
        }
    }
}
