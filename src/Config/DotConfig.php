<?php

namespace VaneaVasco\Toggle\Config;

use Adbar\Dot;

class DotConfig implements Config
{
    protected $dotInstance;

    public function __construct(array $config)
    {
        $this->dotInstance = new Dot($config);
    }

    public function get($key, $default = null)
    {
        return $this->dotInstance->get($key, $default);
    }

    public function isEmpty($key): bool
    {
        return $this->dotInstance->isEmpty($key);
    }

    public function offsetExists($key): bool
    {
        return $this->dotInstance->offsetExists($key);
    }
}
