<?php

namespace Unit\Toggle\PercentToggle;

use Adbar\Dot;
use PHPUnit\Framework\TestCase;
use VaneaVasco\Toggle\Toggle\PercentToggle;


/**
 * Class IsEnabledTest
 * @package Unit\Toggle\SimpleToggle
 */
class IsEnabledTest extends TestCase
{
    /**
     * @dataProvider isEnabledDataProvider
     */
    public function testWhenIsEnabled(string $featureName, array $config, int $rand)
    {
        $percentToggle = $this->getMockBuilder(PercentToggle::class)
                              ->setMethods(['getRand'])
                              ->getMock();

        $percentToggle->method('getRand')
                      ->willReturn(rand(1, $rand));


        $this->assertTrue($percentToggle->isEnabled($featureName, new Dot($config)));
    }

    /**
     * @dataProvider aNonExistingKeyIsProvidedProvider
     */
    public function testWhenANonExistingKeyIsProvided(string $featureName, array $config, int $rand)
    {
        $percentToggle = $this->getMockBuilder(PercentToggle::class)
                              ->setMethods(['getRand'])
                              ->getMock();

        $percentToggle->method('getRand')
                      ->willReturn(rand($rand, 100));


        $this->assertNotTrue($percentToggle->isEnabled($featureName, new Dot($config)));
    }

    /**
     * @dataProvider isNotEnabledDataProvider
     */
    public function testWenIsNotEnabled(string $featureName, array $config, int $rand)
    {
        $percentToggle = $this->getMockBuilder(PercentToggle::class)
                              ->setMethods(['getRand'])
                              ->getMock();

        $percentToggle->method('getRand')
                      ->willReturn(rand($rand, 100));


        $this->assertNotTrue($percentToggle->isEnabled($featureName, new Dot($config)));
    }

    /**
     * @return array
     */
    public function isEnabledDataProvider()
    {
        $featureName = 'myFeature';

        return [
            'enabled 40%' => [
                'featureName' => $featureName,
                'config'      => [
                    $featureName => [
                        'toggle' => PercentToggle::class,
                        'config' => [
                            'probability' => 40
                        ]
                    ],
                ],
                'rand'        => 30
            ]
        ];
    }


    /**
     * @return array
     */
    public function isNotEnabledDataProvider()
    {
        $featureName = 'myFeature';

        return [
            'enabled simple toggle' => [
                'featureName' => $featureName,
                'config'      => [
                    $featureName => [
                        'toggle' => PercentToggle::class,
                        'config' => [
                            'probability' => 40
                        ]
                    ],
                ],
                'rand'        => 50,
            ]
        ];
    }

    /**
     * @return array
     */
    public function aNonExistingKeyIsProvidedProvider()
    {
        $featureName = 'myFeature';

        return [
            'enabled simple toggle' => [
                'featureName' => 'someOtherFeatureName',
                'config'      => [
                    $featureName => [
                        'toggle' => PercentToggle::class,
                        'config' => [
                            'probability' => 40
                        ]
                    ],
                ],
                'rand'        => 40,
            ]
        ];
    }
}
