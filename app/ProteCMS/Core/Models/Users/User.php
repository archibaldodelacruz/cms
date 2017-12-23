<?php

namespace App\ProteCMS\Core\Models\Users;

use App\ProteCMS\Core\Models\Webs\Web;
use App\Helpers\Traits\FilterByWeb;
use App\Helpers\Traits\LogsActivity;
use App\ProteCMS\Core\Models\Pages\PageTranslation;
use App\ProteCMS\Core\Models\Posts\PostTranslation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LogsActivity, FilterByWeb, Notifiable;

    protected $table = 'users';
    protected $touches = ['web'];
    protected $dates = ['last_login'];
    protected $hidden = ['password', 'remember_token'];
    protected $fillable = [
        'id', 'web_id', 'name', 'email', 'password', 'status', 'type', 'last_login', 'created_at', 'updated_at',
    ];

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function isAdminOrVolunteer()
    {
        return $this->type === 'admin' || $this->type === 'volunteer';
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function managePermissions($request)
    {
        $this->permissions()->detach();

        $permissions = [];
        foreach ($request->get('permissions') as $key => $value) {
            if ($value !== '0' && $value !== '1') {
                $permissions[] = $key.'.'.$value;
            } else {
                if ($value !== '0') {
                    $permissions[] = str_replace('.1', '', $key);
                }
            }
        }

        $permissions = Permission::whereIn('permission', $permissions)->select('id')->get();

        if (count($permissions)) {
            $this->permissions()->attach($permissions);
        }

        return $this;
    }

    public function hasPermission($permission)
    {
        if ($this->isAdmin()) {
            return true;
        }

        foreach ($this->permissions as $i => $p) {
            if ($p->permission == $permission) {
                return true;
            }
        }

        return false;
    }

    public function hasPermissions($permissions)
    {
        if ($this->isAdmin()) {
            return true;
        }

        $user_permissions = [];
        foreach ($this->permissions as $permission) {
            $user_permissions[] = $permission->permission;
        }

        foreach ($permissions as $permission) {
            if (in_array($permission, $user_permissions)) {
                return true;
            }
        }

        return false;
    }

    public function animalsPermissions()
    {
        $permissions = [];

        foreach (config('protecms.animals.kind') as $kind) {
            if ($this->isAdmin() || $this->hasPermissions(['admin.panel.animals.'.$kind, 'admin.panel.animals.'.$kind.'.view'])) {
                $permissions[] = $kind;
            }
        }

        return $permissions;
    }

    public function animalsAllPermissions()
    {
        $permissions = [];

        foreach (config('protecms.animals.kind') as $kind) {
            if ($this->isAdmin() || $this->hasPermission('admin.panel.animals.'.$kind)) {
                $permissions[] = $kind;
            }
        }

        return $permissions;
    }

    public function canCreateAnimals()
    {
        $permissions = [];

        foreach (config('protecms.animals.kind') as $kind) {
            if ($this->isAdmin() || $this->hasPermissions(['admin.panel.animals.'.$kind])) {
                $permissions[] = $kind;
            }
        }

        return $permissions;
    }

    public function isBanned()
    {
        return $this->status == 'banned';
    }

    public function web()
    {
        return $this->belongsTo(Web::class);
    }

    public function posts()
    {
        return $this->hasMany(PostTranslation::class);
    }

    public function pages()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions')->withTimestamps();
    }
}
