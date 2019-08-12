<?php

namespace App\Models;

use App\Models\Interfaces\ConnectInterface;
use Illuminate\Database\Eloquent\Model;

class Connect extends Model implements ConnectInterface
{
    protected $table = 'connects';
    protected $guarded = [];
    public $timestamps = true;

}
