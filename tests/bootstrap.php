<?php

$vendorDir = __DIR__ . '/../vendor';

if (!@include($vendorDir . '/autoload.php')) {
    die("You must set up the project dependencies, run the following commands:
            curl -sS https://getcomposer.org/installer | php
            php composer.phar install
            ");
}

$loader = require $vendorDir .  '/autoload.php';
$loader->add('Tests', __DIR__);
