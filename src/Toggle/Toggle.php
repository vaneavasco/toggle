<?php

namespace VaneaVasco\Toggle\Toggle;


interface Toggle
{
    public function isEnabled(array $context);
}
