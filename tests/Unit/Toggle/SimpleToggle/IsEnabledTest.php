<?php

namespace Unit\Toggle\SimpleToggle;

use Adbar\Dot;
use PHPUnit\Framework\TestCase;
use VaneaVasco\Toggle\Toggle\SimpleToggle;


/**
 * Class IsEnabledTest
 * @package Unit\Toggle\SimpleToggle
 */
class IsEnabledTest extends TestCase
{
    /**
     * @dataProvider isEnabledDataProvider
     */
    public function testWhenIsEnabled(string $featureName, array $config)
    {
        $simpleToggle = $this->getMockBuilder(SimpleToggle::class)
                             ->setMethods(null)
                             ->getMock();

        $this->assertTrue($simpleToggle->isEnabled($featureName, new Dot($config)));
    }

    /**
     * @dataProvider aNonExistingKeyIsProvidedProvider
     */
    public function testWhenANonExistingKeyIsProvided(string $featureName, array $config)
    {
        $simpleToggle = $this->getMockBuilder(SimpleToggle::class)
                             ->setMethods(null)
                             ->getMock();


        $this->assertNotTrue($simpleToggle->isEnabled($featureName, new Dot($config)));
    }

    /**
     * @dataProvider isNotEnabledDataProvider
     */
    public function testWenIsNotEnabled(string $featureName, array $config)
    {
        $simpleToggle = $this->getMockBuilder(SimpleToggle::class)
                             ->setMethods(null)
                             ->getMock();

        $this->assertNotTrue($simpleToggle->isEnabled($featureName, new Dot($config)));
    }

    /**
     * @return array
     */
    public function isEnabledDataProvider()
    {
        $featureName = 'myFeature';

        return [
            'enabled simple toggle' => [
                'featureName' => $featureName,
                'config'      => [
                    $featureName => [
                        'toggle' => SimpleToggle::class,
                        'config' => [
                            'enabled' => true
                        ]
                    ],
                ],
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
                        'toggle' => SimpleToggle::class,
                        'config' => [
                            'enabled' => false
                        ]
                    ],
                ],
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
                        'toggle' => SimpleToggle::class,
                        'config' => [
                            'enabled' => true
                        ]
                    ],
                ],
            ]
        ];
    }
}
