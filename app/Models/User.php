<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Exception;
use App\Models\Role;
use App\Models\Service;
use App\Models\Planning;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', 
        'photo'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permissionName)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permissionName)) {
                return true;
            }
        }
        return false;
    }
    
    


    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    public function plannings()
    {
        return $this->hasMany(Planning::class, 'employee_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'employee_service');
    }

    public function getEmployeesByService($serviceId)
    {
        try {
            return Service::findOrFail($serviceId)->employees;
        } catch (Exception $e) {
            return response()->json(['error' => 'Service non trouvé'], 404);
        }
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
