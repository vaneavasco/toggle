<?php

namespace VaneaVasco\Toggle\Config;

interface Config
{
    public function get($key, $default = null);

    public function isEmpty($key): bool;

    public function offsetExists($key): bool;
}
