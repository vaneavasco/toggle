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

    public function isEnabled(string $featureName, array $context = [])
    {
        $featureConfig = $this->config->get($featureName);
        $toggle        = $this->buildToggle($featureConfig['toggle']);

        return $toggle->isEnabled($featureName, $this->config, $context);
    }

    protected function buildToggle($toggleName)
    {
        if (!in_array($toggleName, $this->toggles)) {
            $this->toggles[$toggleName] = $this->toggleFactory->build($toggleName);
        }

        return $this->toggles[$toggleName];
    }
}
