<?php

namespace BasicFormHelper;

/**
 * Created by PhpStorm.
 * User: LOC
 * Date: 1/2/2016
 * Time: 7:05 AM
 */

require_once __DIR__ . '/../src/CommonFunction.php';

class TestUtils {
    public static function getRandomText20($keys = abcdefghijklmnopqrstuvwxyz) {
        return CommonFunction::get_random_string($keys, 20);
    }

    public static function getRandomValueText20($keys = abcdefghijklmnopqrstuvwxyz_special) {
        return CommonFunction::get_random_string($keys, 20);
    }


}