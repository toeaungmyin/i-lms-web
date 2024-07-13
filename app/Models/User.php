<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'STDID',
        'email',
        'phone',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public static function whereRole($roleNames)
    {
        if (!is_array($roleNames)) {
            $roleNames = [$roleNames];
        }

        $roleIds = Role::whereIn('name', $roleNames)->pluck('id');

        return User::whereIn('role_id', $roleIds);
    }


    public function is_role($roleName){
        return $this->role->name === $roleName;
    }

    public function assignRole($roleName)
    {
        $this->update(['role_id' => Role::where('name', $roleName)->first()->id]);
    }

    public function courses(){
        return $this->belongsTo(Course::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }


}
