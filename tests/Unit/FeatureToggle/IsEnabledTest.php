<?php

namespace Unit\FeatureToggle;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use VaneaVasco\Toggle\Config\Config;
use VaneaVasco\Toggle\Config\DotConfig;
use VaneaVasco\Toggle\FeatureToggle;
use VaneaVasco\Toggle\Toggle\Toggle;
use VaneaVasco\Toggle\ToggleFactory;

class IsEnabledTest extends TestCase
{
    /** @var  PHPUnit_Framework_MockObject_MockObject */
    protected $config;
    /** @var  PHPUnit_Framework_MockObject_MockObject */
    protected $toggleFactory;

    /**
     * feature name is empty
     */
    public function testFeatureNameIsEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);
        /** @var FeatureToggle $featureToggle */
        $featureToggle = new FeatureToggle($this->config, $this->toggleFactory);

        $featureToggle->isEnabled('');
    }

    /**
     * invalid feature config
     *
     * @dataProvider invalidFeatureConfigDataProvider
     */
    public function testInvalidFeatureConfig($featureConfig, $featureName, $isEmpty, $offsetExists)
    {
        $this->expectException(\DomainException::class);

        $this->config->expects($this->atMost(1))
                     ->method('offsetExists')
                     ->willReturn($offsetExists);

        $this->config->expects($this->atMost(1))
                     ->method('isEmpty')
                     ->willReturn($isEmpty);

        /** @var FeatureToggle $featureToggle */
        $featureToggle = new FeatureToggle($this->config, $this->toggleFactory);

        $featureToggle->isEnabled($featureName);
    }

    /**
     * valid feature
     */
    public function testValidFeature()
    {
        $this->config->expects($this->atMost(1))
                     ->method('offsetExists')
                     ->willReturn(true);

        $this->config->expects($this->atMost(1))
                     ->method('isEmpty')
                     ->willReturn(false);

        $this->config->expects($this->once())
                     ->method('get')
                     ->willReturn(Toggle::class);

        $mockToggle = $this->getMockBuilder(Toggle::class)
                           ->setMethods(['isEnabled'])
                           ->disableOriginalConstructor()
                           ->getMock();

        $mockToggle->expects($this->once())
                   ->method('isEnabled')
                   ->willReturn(true);

        $this->toggleFactory->expects($this->once())
                            ->method('build')
                            ->willReturn($mockToggle);

        /** @var FeatureToggle $featureToggle */
        $featureToggle = new FeatureToggle($this->config, $this->toggleFactory);


        $isEnabled = $featureToggle->isEnabled('featureName');
        $this->assertTrue($isEnabled);
    }

    public function invalidFeatureConfigDataProvider()
    {
        return [
            'empty config'                        => [
                'featureConfig' => [],
                'featureName'   => 'someFeature',
                'isEmpty'       => true,
                'offsetExists'  => false
            ],
            'non empty config with no toggle key' => [
                ['non empty' => 'array'],
                'featureName'  => 'someFeature',
                'isEmpty'      => false,
                'offsetExists' => false
            ]
        ];
    }

    protected function setUp()
    {
        $this->config = $this->getMockBuilder(Config::class)
                             ->disableOriginalConstructor()
                             ->setMethods(get_class_methods(Config::class))
                             ->getMock();

        $this->toggleFactory = $this->getMockBuilder(ToggleFactory::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
    }
}
