<?php
$mapping = array(
    //later use, change the namespace from app --> App
    'BasicFormHelper\FormHelper' => __DIR__ . '/FormHelper.php',
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require_once $mapping[$class];
    }
}, true);