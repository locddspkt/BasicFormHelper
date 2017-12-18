<?php

namespace BasicFormHelper;

use PHPUnit\Framework\TestCase;

include_once __DIR__ . '/phpunit-autoloader.php';

/**
 * Created by PhpStorm.
 * User: LOC
 * Date: 1/1/2016
 * Time: 10:19 PM
 */

/***
 * Class CommonFunctions_002_Test
 * @package test FormHelper->select
 */
class FormHelper_Select_Test extends TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }


    public function testConvertObjectListToOptions() {
        $formHelper = FormHelper::getInstance();

        //array object with id and name
        $count = random_int(1, 50);
        $list = [];
        for ($i = 0; $i < $count; $i++) {
            $item = new \stdClass();
            $item->id = random_int(1, 100);
            $item->name = CommonFunction::get_random_string(abcdefghijklmnopqrstuvwxyz, 20);
            $list[] = $item;
        }

        $list = $formHelper->convertObjectListToOptions($list);

        $checked = true;
        foreach ($list as $item) {
            if (!key_exists('value', $item)) {
                $checked = false;
                break;
            }
            else if (!key_exists('text', $item)) {
                $checked = false;
                break;
            }
        }

        $this->assertTrue($checked, 'All item has keys value & text');


        //array with custom field
        $count = random_int(1, 50);
        $list = [];
        for ($i = 0; $i < $count; $i++) {
            $item = new \stdClass();
            $item->value_of_the_option = random_int(1, 100);
            $item->text_of_the_option = CommonFunction::get_random_string(abcdefghijklmnopqrstuvwxyz, 20);
            $list[] = $item;
        }

        $list = $formHelper->convertObjectListToOptions($list, ['value' => 'value_of_the_option', 'text' => 'text_of_the_option']);

        $checked = true;
        foreach ($list as $item) {
            if (!key_exists('value', $item)) {
                $checked = false;
                break;
            }
            else if (!key_exists('text', $item)) {
                $checked = false;
                break;
            }
        }
        $this->assertTrue($checked, 'All item has keys value & text');
    }
}