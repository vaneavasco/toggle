<?php

namespace VaneaVasco\Toggle\Toggle;

use Adbar\Dot;

/**
 * Class SimpleToggle
 * @package VaneaVasco\Toggle\Toggle
 */
class SimpleToggle implements Toggle
{
    /**
     * @param string $featureName
     * @param Dot $config
     * @param array $context
     *
     * @return bool
     */
    public function isEnabled(string $featureName, Dot $config, array $context = []): bool
    {
        return $config->has($featureName) && $this->enabled($this->getConfig($featureName, $config));
    }

    protected function enabled($enabled)
    {
        return (bool) $enabled;
    }

    protected function getConfig($featureName, $config): bool
    {
        return $config->get(implode('.', [$featureName, 'config', 'enabled']));
    }
}
