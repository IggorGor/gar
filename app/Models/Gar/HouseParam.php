<?php

namespace App\Models\Gar;
use Illuminate\Database\Eloquent\Model;

class HouseParam extends Model
{
    protected $table = 'gar.house_params';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}
