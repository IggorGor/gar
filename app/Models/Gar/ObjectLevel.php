<?php

namespace App\Models\Gar;

use Illuminate\Database\Eloquent\Model;

class ObjectLevel extends Model
{
    protected $table = 'gar.object_levels';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}
