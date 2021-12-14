<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\SoftDeletes;

include_once(app_path().'/Support/Helpers.php');

class AdminUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'firstname', 'lastname', 'password', 'photo', 'role_id', 'active', 'ip_address', 'access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['hashid','display_photo','created_at_display'];

    public function getHashidAttribute()
    {
        // return encode($this->attributes['id']);
    }

    public function getDisplayPhotoAttribute()
    {
        if($this->photo!='' && File::exists($this->photo)){
            return url($this->photo);
        }
        $name = str_replace(" ", "+", $this->name);
        return 'https://ui-avatars.com/api/?name='.$name.'&background=random';
    }

    public function role()
    {
        return $this->belongsTo('App\Admin\Role', 'role_id');
    }

    public function getCreatedAtDisplayAttribute()
    {
        return $this->created_at ? Carbon::parse($this->created_at)->format('M d, Y') : '';
    }
}