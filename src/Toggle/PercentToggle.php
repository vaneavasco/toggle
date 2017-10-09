<?php

namespace VaneaVasco\Toggle\Toggle;

use VaneaVasco\Toggle\Config\Config;

class PercentToggle implements Toggle
{

    public function isEnabled(string $featureName, Config $config, array $context = [])
    {
        return $config->offsetExists($featureName) && $this->enabled($this->getConfig($featureName, $config));
    }

    protected function enabled($probability): bool
    {
        return $probability >= $this->getRand();
    }

    protected function getConfig($featureName, $config): int
    {
        return $config->get(implode('.', [$featureName, 'config', 'probability']));
    }

    protected function getRand(): int
    {
        return rand(1, 100);
    }
}
