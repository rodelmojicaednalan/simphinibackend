<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'photo',
        'client_id',
        'access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['role', 'display_photo', 'status'];

    public function getRoleAttribute()
    {
        $id = $this->role_id;
        return config('simphini.role')[$id];
    }

    public function getDisplayPhotoAttribute()
    {
        if($this->photo!='' && File::exists($this->photo)){
            return url($this->photo);
        }
        $name = str_replace(" ", "+", $this->name);
        return 'https://ui-avatars.com/api/?name='.$name.'&background=random';
    }

    public function getStatusAttribute()
    {
        if(isset($this->email_verified_at)){
            return 'Active';
        }
        return 'Pending';
    }
}
