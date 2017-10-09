<?php

namespace VaneaVasco\Toggle\Toggle;

use VaneaVasco\Toggle\Config\Config;


/**
 * Class SimpleToggle
 * @package VaneaVasco\Toggle\Toggle
 */
class SimpleToggle implements Toggle
{
    /**
     * @param string $featureName
     * @param Config $config
     * @param array $context
     *
     * @return bool
     */
    public function isEnabled(string $featureName, Config $config, array $context = []): bool
    {
        return $config->offsetExists($featureName) && $this->enabled($this->getConfig($featureName, $config));
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
