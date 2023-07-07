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
        }

        $roles = User::select('roles')->where('id', $userId)->firstOrFail();
        foreach ($roles->roles as $server) {
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
        }
        $roles = User::select('roles')->where('id', $userId)->firstOrFail();

        $tmpRoles = [];
        $roleCases = Roles::cases();
        foreach ($roles->roles as $server) {
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
}
