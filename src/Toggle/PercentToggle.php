<?php

namespace VaneaVasco\Toggle\Toggle;

use Adbar\Dot;

class PercentToggle implements Toggle
{

    public function isEnabled(string $featureName, Dot $config, array $context = [])
    {
        return $config->has($featureName) && $this->enabled($this->getConfig($featureName, $config));
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
