<?php

namespace App\Observers;

use App\Enums\Roles;
use App\Models\User;

class AbstractObserver
{
    protected function setRank(User $user)
    {
        if (in_array(Roles::Offizier->value, $user->roles[121399943393968128])) {
            $user->rank = "Offizier";
        }
        if (in_array(Roles::Unteroffizier->value, $user->roles[121399943393968128])) {
            $user->rank = "Unteroffizier";
        }
        if (in_array(Roles::Veteran->value, $user->roles[121399943393968128])) {
            $user->rank = "Veteran";
        }
        if (in_array(Roles::Soldat->value, $user->roles[121399943393968128])) {
            $user->rank = "Soldat";
        }
        if (in_array(Roles::Rekrut->value, $user->roles[121399943393968128])) {
            $user->rank = "Rekrut";
        }
        $user->save();
    }
}
