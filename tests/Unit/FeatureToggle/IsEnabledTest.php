<?php

namespace Unit\FeatureToggle;

use Adbar\Dot;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
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
        $featureToggle = $this->getMockBuilder(FeatureToggle::class)
                              ->setConstructorArgs([$this->config, $this->toggleFactory])
                              ->setMethodsExcept(['isEnabled'])
                              ->getMock();

        $featureToggle->isEnabled('');
    }

    /**
     * invalid feature config
     *
     * @dataProvider invalidFeatureConfigDataProvider
     */
    public function testInvalidFeatureConfig($featureConfig, $featureName)
    {
        $this->expectException(\DomainException::class);

        $this->config->expects($this->once())
                     ->method('get')
                     ->willReturn($featureConfig);

        /** @var FeatureToggle $featureToggle */
        $featureToggle = $this->getMockBuilder(FeatureToggle::class)
                              ->setConstructorArgs([$this->config, $this->toggleFactory])
                              ->setMethodsExcept(['isEnabled'])
                              ->getMock();

        $featureToggle->isEnabled($featureName);
    }

    /**
     * valid feature
     */
    public function testValidFeature()
    {
        $this->config->expects($this->once())
                     ->method('get')
                     ->willReturn([
                         'toggle' => Toggle::class
                     ]);

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
        $featureToggle = $this->getMockBuilder(FeatureToggle::class)
                              ->setConstructorArgs([$this->config, $this->toggleFactory])
                              ->setMethodsExcept(['isEnabled', 'buildToggle'])
                              ->getMock();


        $isEnabled = $featureToggle->isEnabled('featureName');
        $this->assertTrue($isEnabled);
    }

    public function invalidFeatureConfigDataProvider()
    {
        return [
            'empty config'                        => ['featureConfig' => [], 'featureName' => 'someFeature'],
            'non empty config with no toggle key' => [['non empty' => 'array'], 'featureName' => 'someFeature']
        ];
    }

    protected function setUp()
    {
        $this->config = $this->getMockBuilder(Dot::class)
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->toggleFactory = $this->getMockBuilder(ToggleFactory::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
    }
}
