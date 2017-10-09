<?php

namespace Unit\ToggleFactory;

use PHPUnit\Framework\TestCase;
use VaneaVasco\Toggle\Toggle\SimpleToggle;
use VaneaVasco\Toggle\Toggle\Toggle;
use VaneaVasco\Toggle\ToggleFactory;

class BuildTest extends TestCase
{
    /**
     * build valid toggle
     *
     * @dataProvider validTogglesProvider
     *
     * @param string $toggleName
     */
    public function testBuildValidToggle(string $toggleName)
    {
        $toggleFactory = $this->getMockBuilder(ToggleFactory::class)
                              ->disableOriginalConstructor()
                              ->setMethods(null)
                              ->getMock();

        $this->assertInstanceOf(Toggle::class, $toggleFactory->build($toggleName));
    }

    /**
     * build invalid toggle
     *
     * @dataProvider invalidTogglesProvider
     *
     * @param string $toggleName
     */
    public function testBuildInvalidToggle(string $toggleName)
    {
        $this->expectException(\InvalidArgumentException::class);
        $toggleFactory = $this->getMockBuilder(ToggleFactory::class)
                              ->disableOriginalConstructor()
                              ->setMethods(null)
                              ->getMock();

        $toggleFactory->build($toggleName);
    }


    public function validTogglesProvider()
    {
        return [
            'SimpleToggle' => [SimpleToggle::class]
        ];
    }

    public function invalidTogglesProvider()
    {
        return [
            'randomToggleName' => ['someRandomToggleName']
        ];
    }
}
