<?php
$mapping = array(
    'BasicFormHelper\TestUtils' => __DIR__ . '/TestUtils.php',
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require_once $mapping[$class];
    }
}, true);