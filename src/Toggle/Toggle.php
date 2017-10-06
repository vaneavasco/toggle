<?php

namespace VaneaVasco\Toggle\Toggle;


use Adbar\Dot;

interface Toggle
{
    public function isEnabled(string $featureName, Dot $config, array $context);
}
