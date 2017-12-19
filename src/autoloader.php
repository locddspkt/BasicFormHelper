<?php
$mapping = array(
    'CommonFunction' => __DIR__ . '/CommonFunction.php',
    'BasicFormHelper\FormHelper' => __DIR__ . '/FormHelper.php',
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require_once $mapping[$class];
    }
}, true);