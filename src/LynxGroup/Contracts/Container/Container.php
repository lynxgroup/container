<?php namespace LynxGroup\Contracts\Container;

interface Container
{
    public function singleton(callable $concrete);

    public function __set($abstract, callable $concrete);

    public function __get($abstract);

    public function __call($abstract, $args);

    public function getFactory($abstract);
}
