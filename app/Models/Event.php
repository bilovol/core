<?php

namespace App\Models;

use App\Models\Interfaces\EventInterface;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements EventInterface
{
    protected $table = 'events';

    protected $casts = [
        'fields' => 'array'
    ];

    protected $guarded = [];
}
