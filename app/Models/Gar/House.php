<?php

namespace App\Models\Gar;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $table = 'gar.houses';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}
