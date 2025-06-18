<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LightStatus extends Model
{
    protected $fillable = [
        'is_on',
        'ldr_value',
        'mode',
        'manual_override',
    ];

    protected $casts = [
        'is_on' => 'boolean',
        'manual_override' => 'boolean',
        'ldr_value' => 'integer',
    ];
}
