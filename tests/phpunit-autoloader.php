<?php
$mapping = array(
    'BasicFormHelper\TestUtils' => __DIR__ . '/TestUtils.php',
    'BasicFormHelper\CommonFunction' => __DIR__ . '/CommonFunction.php',
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require_once $mapping[$class];
    }
}, true);