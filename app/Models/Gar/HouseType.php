<?php

namespace App\Models\Gar;

use Illuminate\Database\Eloquent\Model;

class HouseType extends Model
{
    protected $table = 'gar.house_types';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

}
