<?php

return [
    'provider' => env('VFP_PROVIDER', 'VFPOLEDB.1'),
    'source'   => env('VFP_SOURCE'),
    'mode'    => 'Read',
    'audit'    => env('VFP_AUDIT', false),
];
