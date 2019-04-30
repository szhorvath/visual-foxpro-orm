<?php

namespace Szhorvath\FoxproDB;

/**
 * Base model for Visual Foxpro
 */
abstract class Model
{
    protected $connection;

    protected $casts;

    public function __construct()
    {
        // dd($this->table);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }


    public function __call($method, $parameters)
    {
        dd($this);

        $query = $this->newQuery();

        return call_user_func_array(array($query, $method), $parameters);
    }

    // public static function all()
    // {
    //     return 'hello';
    // }

    public static function query()
    {
    }


    public function newQuery()
    {
        //need query builder
    }
}
