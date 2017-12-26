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
class FormHelper_Hidden_Test extends TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }

    private function baseCheckHidden($input) {
        $this->assertContains('<input', $input, 'Valid hidden');
        $this->assertContains("type='hidden'", $input, 'Valid hidden');
        $this->assertContains("/>", $input, 'Valid hidden');
    }

    public function testBuildHidden() {
        $formHelper = FormHelper::getInstance();
        //empty hidden, return the empty hidden input
        $input = $formHelper->hidden();
        $this->baseCheckHidden($input);

        //hidden with field name = false -> do not generate name
        $name = false;
        $input = $formHelper->hidden($name);
        $this->baseCheckHidden($input);
        $this->assertNotContains(' name=', $input, 'Do not generate name');

        //hidden with random valid name
        $name = TestUtils::getRandomText20();
        $input = $formHelper->hidden($name);
        $this->baseCheckHidden($input);
        $this->assertContains(' name=', $input, 'Input has the name');
        $this->assertContains($name, $input);
        $this->assertNotContains('value=', $input, 'Do not have value');

        //hidden with option['value']
        $name = TestUtils::getRandomText20();
        $value = TestUtils::getRandomText20();
        $input = $formHelper->hidden($name, ['value' => $value]);
        $this->baseCheckHidden($input);
        $this->assertContains(' name=', $input, 'Has name');
        $this->assertContains(' value=', $input, 'Has value');
        $this->assertContains($name, $input, 'Match the value');

        //hidden with option['default']
        $name = TestUtils::getRandomText20();
        $value = TestUtils::getRandomText20();
        $input = $formHelper->hidden($name, ['default' => $value]);
        $this->baseCheckHidden($input);
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

        $input = $formHelper->hidden($name, ['default' => $value], $attributes);
        $this->baseCheckHidden($input);

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

    private function getRandomText20() {
        return CommonFunction::get_random_string(abcdefghijklmnopqrstuvwxyz, 20);
    }
}