<?php

namespace App\Models\Gar;
use Illuminate\Database\Eloquent\Model;

class AddrObj extends Model
{
    protected $table = 'gar.addr_objs';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];
}
