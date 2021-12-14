<?php

namespace App\Models\Admin\Picklists;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\HashidsManager;

class Treatment extends Model
{
    protected $table = "picklists_treatments";
    protected $guarded = [];

    protected $fillable = [
        'name', 'description', 'status', 'updated_at', 'created_at',
    ];

    protected $appends = ['hashedid'];

    public function getHashedidAttribute()
    {
        return \Hashids::encode($this->id);
    }
}
