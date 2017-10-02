<?php

namespace VaneaVasco\Toggle\Toggle;


class SimpleToggle implements Toggle
{
    /** @var array */
    protected $config;
    /** @var  string */
    protected $featureName;

    public function __construct(array $config, string $featureName)
    {
        $this->config      = $config;
        $this->featureName = $featureName;
    }

    /**
     * @param array $context
     *
     * @return bool
     */
    public function isEnabled(array $context): bool
    {
        return array_key_exists($this->featureName, $this->config) && $this->config[$this->featureName] === true;
    }
}
