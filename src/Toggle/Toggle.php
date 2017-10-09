<?php

namespace VaneaVasco\Toggle\Toggle;

use VaneaVasco\Toggle\Config\Config;

interface Toggle
{
    public function isEnabled(string $featureName, Config $config, array $context);
}
