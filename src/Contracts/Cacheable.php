<?php

namespace Szhorvath\FoxproDB\Contracts;

/**
 * Cache interface for foxpro model
 */
interface Cacheable
{
    public function cache($params);
}
