<?php

namespace App\Models\Gar;

use Illuminate\Database\Eloquent\Model;

class GarDataByUUID extends Model
{
    public $timestamps = false;
    protected $table = 'gar.gar_data_by_uuid';
}
