<?php

namespace App\Models\Admin\Picklists;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\HashidsManager;

class Country extends Model
{
    protected $table = "picklists_countries";
    protected $guarded = [];

    protected $fillable = [
        'name', 'code', 'nationality', 'updated_at', 'created_at',
    ];

    protected $appends = ['hashedid'];

    public function getHashedidAttribute()
    {
        return \Hashids::encode($this->id);
    }
}
