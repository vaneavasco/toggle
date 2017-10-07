<?php

use VaneaVasco\Toggle\Toggle\PercentToggle;
use VaneaVasco\Toggle\Toggle\SimpleToggle;

return [
    'myFeature'      => [
        'toggle' => SimpleToggle::class,
        'config' => [
            'enabled' => true
        ]
    ],
    'myOtherFeature' => [
        'toggle' => PercentToggle::class,
        'config' => [
            'probability' => 40
        ]
    ],
];