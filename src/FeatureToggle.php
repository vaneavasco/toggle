<?php

namespace VaneaVasco\Toggle;

use Adbar\Dot;
use VaneaVasco\Toggle\Toggle\Toggle;

class FeatureToggle
{
    /** @var Dot */
    protected $config;

    /** @var  Toggle[] */
    protected $toggles;
    /**
     * @var ToggleFactory
     */
    private $toggleFactory;

    public function __construct(Dot $config, ToggleFactory $toggleFactory)
    {
        $this->config        = $config;
        $this->toggleFactory = $toggleFactory;
        $this->toggles       = [];
    }

    public static function build(array $config): FeatureToggle
    {
        return new static(new Dot($config), new ToggleFactory());
    }

    public function isEnabled(string $featureName, array $context = []): bool
    {
        if (empty($featureName)) {
            throw new \InvalidArgumentException('Feature name cannot be empty.');
        }
        $featureConfig = $this->config->get($featureName);

        if (empty($featureConfig) || !array_key_exists('toggle', $featureConfig)) {
            throw new \DomainException('Invalid feature config.');
        }
        $toggle = $this->buildToggle($featureConfig['toggle']);

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
