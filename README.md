# Simple feature toggles
[![Build status][ico-travis]][link-travis]

Example
```php

$featureConfig   = require_once 'config.php';
$featureToggle   = FeatureToggle::build($featureConfig);
$featuresToCheck = ['myFeature', 'myOtherFeature'];

foreach ($featuresToCheck as $feature) {
    if ($featureToggle->isEnabled($feature)) {
        echo "$feature is enabled \n";
    } else {
        echo "$feature is disabled \n";
    }
}
```
[ico-travis]: https://travis-ci.org/vaneavasco/toggle.svg?branch=master
[link-travis]: https://travis-ci.org/vaneavasco/toggle