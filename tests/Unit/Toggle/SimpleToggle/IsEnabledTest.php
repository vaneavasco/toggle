<?php

namespace Unit\Toggle\SimpleToggle;

use PHPUnit\Framework\TestCase;
use VaneaVasco\Toggle\Toggle\SimpleToggle;


class IsEnabledTest extends TestCase
{
    /**
     * @dataProvider isEnabledDataProvider
     */
    public function testWhenIsEnabled($data)
    {
        $simpleToggle = $this->getMockBuilder(SimpleToggle::class)
                             ->setConstructorArgs($data)
                             ->setMethods(null)
                             ->getMock();


        $this->assertTrue($simpleToggle->isEnabled([]));
    }

    public function testWhenANonExistingKeyIsProvided()
    {
        $simpleToggle = $this->getMockBuilder(SimpleToggle::class)
                             ->setConstructorArgs(['config' => ['featureName' => true], 'someFeatureName'])
                             ->setMethods(null)
                             ->getMock();

        $this->assertNotTrue($simpleToggle->isEnabled([]));
    }

    public function testWenIsNotEnabled()
    {
        $simpleToggle = $this->getMockBuilder(SimpleToggle::class)
                             ->setConstructorArgs(['config' => ['featureName' => false], 'featureName'])
                             ->setMethods(null)
                             ->getMock();

        $this->assertNotTrue($simpleToggle->isEnabled([]));
    }

    public function isEnabledDataProvider()
    {
        return [
            'simple feature' => [['config' => ['featureName' => true], 'featureName']]
        ];
    }
}
