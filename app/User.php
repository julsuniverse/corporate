<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public  function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'role_user');
    }

    /**
     * @param $permission
     * @param bool|array $require
     * if true, function will return true only when all permissions in array are allowed
     * @return bool
     */
    public function canDo($permission, $require = false)
    {
        if(is_array($permission)) {
            foreach($permission as $permName) {
                 $permName = $this->canDo($permName);
                 if ($permName && !$require)
                     return true;
                 else if (!$permName && $require)
                     return false;
            }

            return true;
        } else {
            foreach($this->roles as $role) {
                foreach($role->permissions as $perm) {
                    if(str_is($permission, $perm->name)) {
                        return true;
                    }
                }
            }
        }
    }

    /**
     * @param $name
     * @param bool|array $require
     * @return bool
     */
    public function hasRole($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if($hasRole && !$require) {
                    return true;
                }
                else if (!$hasRole && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach($this->roles as $role) {
                if($role->name == $name) {
                    return true;
                }
            }
        }
    }


}
