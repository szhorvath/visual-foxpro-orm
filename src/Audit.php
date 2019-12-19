<?php

namespace Szhorvath\FoxproDB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Szhorvath\FoxproDB\Models\FoxproAudit;

class Audit
{
    public static function log($query)
    {
        return FoxproAudit::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'query' => $query,
            'ip' => Request::ip(),
            'url' => Request::fullUrl(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }
}
