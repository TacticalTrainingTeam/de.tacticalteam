<?php

namespace App\Models;

use App\Enums\Roles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Jakyeru\Larascord\Traits\InteractsWithDiscord;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithDiscord;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'username',
        'global_name',
        'discriminator',
        'email',
        'avatar',
        'verified',
        'banner',
        'rank',
        'steam_id',
        'banner_color',
        'accent_color',
        'locale',
        'mfa_enabled',
        'premium_type',
        'public_flags',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'global_name' => 'string',
        'discriminator' => 'string',
        'email' => 'string',
        'avatar' => 'string',
        'verified' => 'boolean',
        'banner' => 'string',
        'rank' => 'string',
        'steam_id' => 'string',
        'banner_color' => 'string',
        'accent_color' => 'string',
        'locale' => 'string',
        'mfa_enabled' => 'boolean',
        'premium_type' => 'integer',
        'public_flags' => 'integer',
        'roles' => 'json',
    ];

    /**
     * Prüft ob ein User in einer gewissen Rolle ist
     * @param Roles $role
     * @param $userId
     * @return bool
     * @author Andre/Isaac
     */
    public static function UserIn(Roles $role, $userId = null): bool
    {
        $overrideUsers = [185411970630025219];

        if ($userId === null) {
            $userId = Auth::id();
            $roles = Auth::user()['roles'];
        } else {
            $roles = User::select('roles')->where('id', $userId)->firstOrFail();
        }

        if (is_object($roles)) {
            $roles = $roles->roles;
        }
        foreach ($roles as $server) {
            foreach ($server as $serverRoles) {
                if ($serverRoles == Roles::Offizier->value or in_array(Auth::id(), $overrideUsers) ) {
                    return true;
                }
                if ($role->value == $serverRoles) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function getRawRoles($roles, $readable = false)
    {
        $tmpRoles = [];
        $roleCases = Roles::cases();
        foreach ($roles as $server) {
            foreach ($server as $serverRoles) {
                $index = array_search($serverRoles, array_column($roleCases, "value"));
                if ($index != false) {
                    if ($readable) {
                        $tmpRoles[] = $roleCases[$index]->name;
                    } else {
                        $tmpRoles[] = $roleCases[$index]->value;
                    }
                }
            }
        }
        return $tmpRoles;
    }

    /**
     * Gibt alle Rollen eines Users zurück
     * @param $userId
     * @param bool $readable
     * @return array
     * @author Andre/Isaac
     */
    public static function getAllRolesOfUser($userId = null, bool $readable = false): array
    {
        if ($userId === null) {
            $userId = Auth::id();
            $roles = Auth::user()['roles'];
        } else {
            $roles = User::select('roles')->where('id', $userId)->firstOrFail();
        }

        $tmpRoles = [];
        $roleCases = Roles::cases();
        if (is_object($roles)) {
            $roles = $roles->roles;
        }
        foreach ($roles as $server) {
            foreach ($server as $serverRoles) {
                $index = array_search($serverRoles, array_column($roleCases, "value"));
                if ($index != false) {
                    if ($readable) {
                        $tmpRoles[] = $roleCases[$index]->name;
                    } else {
                        $tmpRoles[] = $roleCases[$index]->value;
                    }
                }
            }
        }
        return $tmpRoles;
    }

    /**
     * @param User|null $user
     * @return string|void
     * @author Andre/Isaac
     */
    public static function getTTTRank(User $user = null)
    {
        if ($user === null) {
            $user = Auth::user();
        }

        if (in_array(Roles::Offizier->value, $user->roles[121399943393968128])) {
            return "Offizier";
        }
        if (in_array(Roles::Unteroffizier->value, $user->roles[121399943393968128])) {
            return "Unteroffizier";
        }
        if (in_array(Roles::Veteran->value, $user->roles[121399943393968128])) {
            return "Veteran";
        }
        if (in_array(Roles::Soldat->value, $user->roles[121399943393968128])) {
            return "Soldat";
        }
        if (in_array(Roles::Rekrut->value, $user->roles[121399943393968128])) {
            return "Rekrut";
        }
    }
}
