<?php

namespace VaneaVasco\Toggle;

use VaneaVasco\Toggle\Toggle\PercentToggle;
use VaneaVasco\Toggle\Toggle\SimpleToggle;
use VaneaVasco\Toggle\Toggle\Toggle;

class ToggleFactory
{
    protected $toggleWhiteList = [
        SimpleToggle::class,
        PercentToggle::class
    ];

    /**
     * @param $toggle
     *
     * @return Toggle
     */
    public function build($toggle): Toggle
    {
        if (!in_array($toggle, $this->toggleWhiteList)) {
            throw new \InvalidArgumentException('Invalid toggle.');
        }

        return new $toggle();
    }
}