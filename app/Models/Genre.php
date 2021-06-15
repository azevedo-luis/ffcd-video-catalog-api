<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    //aqui preciso por quais campos são seguros
    use SoftDeletes, \App\Models\Traits\Uuid;
    protected $fillable = ['name', 'is_active'];
    protected $dates = ['deleted_at'];
    protected $casts = ['is_active' => 'boolean'];
    public $incrementing = false;
    protected $KeyType = 'String';
}
