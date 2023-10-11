<?php

namespace App\Models\Gar;

use Illuminate\Database\Eloquent\Model;

class ParamType extends Model
{
    protected $table = 'gar.param_types';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}
