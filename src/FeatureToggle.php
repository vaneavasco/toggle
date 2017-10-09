<?php

namespace VaneaVasco\Toggle;

use VaneaVasco\Toggle\Config\Config;
use VaneaVasco\Toggle\Config\DotConfig;
use VaneaVasco\Toggle\Toggle\Toggle;

class FeatureToggle
{
    /** @var Config */
    protected $config;

    /** @var  Toggle[] */
    protected $toggles;
    /**
     * @var ToggleFactory
     */
    private $toggleFactory;

    public function __construct(Config $config, ToggleFactory $toggleFactory)
    {
        $this->config        = $config;
        $this->toggleFactory = $toggleFactory;
        $this->toggles       = [];
    }

    public static function build(array $config): FeatureToggle
    {
        return new static(new DotConfig($config), new ToggleFactory());
    }

    public function isEnabled(string $featureName, array $context = []): bool
    {
        if (empty($featureName)) {
            throw new \InvalidArgumentException('Feature name cannot be empty.');
        }


        $featureConfigKey = implode('.', [$featureName, 'toggle']);
        if (!$this->config->offsetExists($featureName) || $this->config->isEmpty($featureConfigKey)) {
            throw new \DomainException('Invalid feature config.');
        }
        $toggle = $this->buildToggle($this->config->get($featureConfigKey));

        return $toggle->isEnabled($featureName, $this->config, $context);
    }

    protected function buildToggle(string $toggleName): Toggle
    {
        if (!in_array($toggleName, $this->toggles)) {
            $this->toggles[$toggleName] = $this->toggleFactory->build($toggleName);
        }

        return $this->toggles[$toggleName];
    }
}
