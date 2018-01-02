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
class FormHelper_Input_Test extends TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }

    private function baseCheckInput($input) {
        $this->assertContains('<input', $input, 'Valid input');
        $this->assertContains("type='text'", $input, 'Valid input');
        $this->assertContains("/>", $input, 'Valid input');
    }

    public function testBuildInput() {
        $formHelper = FormHelper::getInstance();
        //empty input, return the empty input input
        $input = $formHelper->input();
        $this->baseCheckInput($input);

        //input with field name = false -> do not generate name
        $name = false;
        $input = $formHelper->input($name);
        $this->baseCheckInput($input);
        $this->assertNotContains(' name=', $input, 'Do not generate name');

        //input with random valid name
        $name = TestUtils::getRandomText20();
        $input = $formHelper->input($name);
        $this->baseCheckInput($input);
        $this->assertContains(' name=', $input, 'Input has the name');
        $this->assertContains($name, $input);
        $this->assertNotContains('value=', $input, 'Do not have value');

        //input with option['value']
        $name = TestUtils::getRandomText20();
        $value = TestUtils::getRandomText20();
        $input = $formHelper->input($name, ['value' => $value]);
        $this->baseCheckInput($input);
        $this->assertContains(' name=', $input, 'Has name');
        $this->assertContains(' value=', $input, 'Has value');
        $this->assertContains($name, $input, 'Match the value');

        //input with option['default']
        $name = TestUtils::getRandomText20();
        $value = TestUtils::getRandomText20();
        $input = $formHelper->input($name, ['default' => $value]);
        $this->baseCheckInput($input);
        $this->assertContains(' name=', $input, 'Has name');
        $this->assertContains(' value=', $input, 'Has value');
        $this->assertContains($name, $input, 'Match the value');

        //get some random attributes
        $count = random_int(0, 10);
        $attributes = [];
        for ($i = 1; $i <= $count; $i++) {
            do {
                $attribute = TestUtils::getRandomText20();
            } while (in_array($attribute, array_keys($attributes)));

            $attributes[$attribute] = TestUtils::getRandomText20();
        }

        $input = $formHelper->input($name, ['default' => $value], $attributes);
        $this->baseCheckInput($input);

        $checked = true;
        //all the attributes must be in the option
        foreach ($attributes as $attribute => $attributeValue) {
            if (strpos($input, $attribute) === false || strpos($input, $attributeValue) === false) {
                $checked = false;
                break;
            }
        }

        $this->assertTrue($checked, 'Match all the attributes');
    }
}