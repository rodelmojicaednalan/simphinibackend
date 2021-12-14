<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "clients";
    protected $guarded = [];
    protected $appends = ['hashid'];

    public function getHashidAttribute()
    {
        return encode($this->attributes['id']);
    }
}
