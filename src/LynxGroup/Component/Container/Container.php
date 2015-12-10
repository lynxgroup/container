<?php namespace LynxGroup\Component\Container;

use LynxGroup\Contracts\Container\Container as ContainerInterface;

class Container implements ContainerInterface
{
    protected $container = [];

    public function singleton(callable $concrete)
    {
        return function() use($concrete)
        {
            static $object;

            if( !$object )
            {
                $object = call_user_func_array($concrete, func_get_args());
            }

            return $object;
        };
    }

    public function __set($abstract, callable $concrete)
    {
        $this->container[$abstract] = $concrete;
    }

    public function __get($abstract)
    {
        return $this->$abstract();
    }

    public function __call($abstract, $args)
    {
        if( !isset($this->container[$abstract]) )
        {
            throw new \InvalidArgumentException($abstract);
        }

        return call_user_func_array($this->container[$abstract], $args);
    }

    public function getFactory($abstract)
    {
        if( !isset($this->container[$abstract]) )
        {
            throw new \InvalidArgumentException($abstract);
        }

        return $this->container[$abstract];
    }
}
