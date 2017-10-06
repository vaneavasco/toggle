<?php

use VaneaVasco\Toggle\Toggle\PercentToggle;

return [
    'myFeature' => [
        'toggle' => \VaneaVasco\Toggle\Toggle\SimpleToggle::class,
        'config' => [
            'enabled' => true
        ]
    ],
    'myOtherFeature' => [
        [
            'toggle' => PercentToggle::class,
            'config' => [
                'probability' => 40
            ]
        ]
    ]
];