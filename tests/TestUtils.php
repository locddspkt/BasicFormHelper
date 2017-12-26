<?php

namespace BasicFormHelper;

/**
 * Created by PhpStorm.
 * User: LOC
 * Date: 1/2/2016
 * Time: 7:05 AM
 */
class TestUtils {
    public static function getRandomText20() {
        return CommonFunction::get_random_string(abcdefghijklmnopqrstuvwxyz, 20);
    }
}