<?php


namespace BasicFormHelper;


use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Test;

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
class FormHelper_Checkbox_Test extends TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }

    private function baseCheckCheckbox($input) {
        $this->assertContains('<input', $input, 'Valid input');
        $this->assertContains("type='checkbox'", $input, 'Valid input');
        $this->assertContains("/>", $input, 'Valid input');
    }

    private function baseCheckHidden($input) {
        $this->assertContains('<input', $input, 'Valid input');
        $this->assertContains("type='hidden'", $input, 'Valid input');
        $this->assertContains("/>", $input, 'Valid input');
    }

    public function testBuildCheckbox() {
        $formHelper = FormHelper::getInstance();
        //empty input, return the empty checkbox
        $input = $formHelper->checkbox();
        $this->baseCheckCheckbox($input);
        $this->baseCheckHidden($input);

        //input with field name = false -> do not generate name
        $name = false;
        $input = $formHelper->checkbox($name);
        $this->baseCheckCheckbox($input);
        $this->baseCheckHidden($input);
        $this->assertNotContains(' name=', $input, 'Do not generate name');

        //input with random valid name
        $name = TestUtils::getRandomText20();
        $input = $formHelper->checkbox($name);
        $this->baseCheckCheckbox($input);
        $this->baseCheckHidden($input);
        $this->assertContains(' name=', $input, 'Input has the name');
        $this->assertContains($name, $input);
        $this->assertSame(1, substr_count($input,"value='0'"), $input, 'one hidden value = 0');
        $this->assertSame(1, substr_count($input,"value='1'"), $input, 'one value = 1');

        //input with option['value']
        $name = TestUtils::getRandomText20();
        $value = TestUtils::getRandomText20();
        $input = $formHelper->checkbox($name, ['value' => $value]);
        $this->baseCheckCheckbox($input);
        $this->baseCheckHidden($input);
        $this->assertContains(' name=', $input, 'Has name');
        $this->assertContains(' value=', $input, 'Has value');
        $this->assertContains($name, $input, 'Match the value');

        //input with option['default']
        $name = TestUtils::getRandomText20();
        $value = TestUtils::getRandomText20();
        $input = $formHelper->checkbox($name, ['default' => $value]);
        $this->baseCheckCheckbox($input);
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

        $input = $formHelper->checkbox($name, ['default' => $value], $attributes);
        $this->baseCheckCheckbox($input);
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

        //do not set hidden field
        $input = $formHelper->checkbox($name, ['default' => $value, 'hiddenField' => false], $attributes);
        $this->baseCheckCheckbox($input);
        $this->assertNotContains("type='hidden'", $input, 'Do not have hidden field');

        //hidden field with specific value
        $hiddenFieldValue = TestUtils::getRandomText20();
        var_dump($hiddenFieldValue);
        $input = $formHelper->checkbox($name, ['default' => $value, 'hiddenField' => $hiddenFieldValue], $attributes);
        $this->baseCheckCheckbox($input);
        $this->baseCheckHidden($input);
        $this->assertContains("value='$hiddenFieldValue'", $input, "Has hidden field value");
    }
}