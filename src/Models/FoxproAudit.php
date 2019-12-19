<?php

namespace Szhorvath\FoxproDB\Models;

use Illuminate\Database\Eloquent\Model;

class FoxproAudit extends Model
{
    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'query',
        'ip',
        'url',
        'user_agent',
    ];
}
