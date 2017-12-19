<?php


namespace BasicFormHelper;


use PHPUnit\Framework\TestCase;
use CommonFunction;

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
            $item->name = $this->getRandomText20();
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
            $item->text_of_the_option = $this->getRandomText20();
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

    public function testBuildSelect() {
        $formHelper = FormHelper::getInstance();

        //select with field name = false -> do not generate name
        $name = false;
        $select = $formHelper->select($name);
        $this->assertNotContains(' name=', $select, 'Do not generate name');
        $this->assertNotContains('<option', $select, 'Do not have any options');
        $this->assertNotContains('</option>', $select, 'Do not have any options');

        //select with random valid name
        $name = $this->getRandomText20();
        $select = $formHelper->select($name);
        $this->assertContains(' name=', $select);
        $this->assertContains($name, $select);
        $this->assertNotContains('<option', $select, 'Do not have any options');
        $this->assertNotContains('</option>', $select, 'Do not have any options');

        //some options
        $optionCount = random_int(1,50);
        $options = [];
        for ($i=1;$i<=$optionCount;$i++) {
            $options[] = $this->getRandomText20();
        }
        $select = $formHelper->select($name, $options);
        $this->assertContains('<option', $select, 'Do not have any options');
        $this->assertContains('</option>', $select, 'Do not have any options');

        //options has no key
        $checked = true;
        foreach ($options as $option) {
            if (strpos($select,"$option") === false) {
                $checked = false;
                break;
            }
        }
        $this->assertTrue($checked, 'Match all the option');
        $this->assertSame($optionCount, substr_count($select, '</option>'), 'Equal with item count');

        //dont have empty
        $select = $formHelper->select($name, $options,['empty' => false]);
        $this->assertSame($optionCount, substr_count($select, '</option>'), 'Equal with item count');

        //have the empty default row
        $select = $formHelper->select($name, $options,['empty' => true]);
        $this->assertSame($optionCount +1, substr_count($select, '</option>'), 'Equal with item count');

        //have the default row
        $select = $formHelper->select($name, $options,['empty' => ['value' => $this->getRandomText20(), 'text' => $this->getRandomText20()]]);
        $this->assertSame($optionCount +1, substr_count($select, '</option>'), 'Equal with item count');

        //random options with random keys
        $options = [];
        for ($i=1;$i<=$optionCount;$i++) {
            do {
                $key = $this->getRandomText20();
                $text = $this->getRandomText20();
            } while (in_array($key, array_keys($options)) || in_array($text, $options));
            $options[$key] = $text;
        }

        $select = $formHelper->select($name, $options);
        $this->assertSame($optionCount, substr_count($select, ' value='),'Same items with options');

        $checked = true;
        foreach ($options as $value=>$text) {
            if (strpos($select,"$value") === false || strpos($select,"$text") === false) {
                $checked = false;
                break;
            }
        }

        $this->assertTrue($checked, 'Match all the option');

        //selected is one of the option
        $selectedIndex = random_int(0,$optionCount-1);
        $selected = array_keys($options)[$selectedIndex];
        $select = $formHelper->select($name, $options, ['selected' => $selected]);
        $this->assertContains(' selected', $select, 'Has selected in the select');

        //random options and items are array
        $options = [];
        $optionsInSelect = [];
        for ($i=1;$i<=$optionCount;$i++) {
            do {
                $key = $this->getRandomText20();
                $text = $this->getRandomText20();
            } while (in_array($key, array_keys($options)) || in_array($text, $options));
            $options[$key] = $text;
            $optionsInSelect[] = ['value' => $value, 'text' => $text];

        }

        $select = $formHelper->select($name, $optionsInSelect);
        $this->assertSame($optionCount, substr_count($select, ' value='),'Same items with options');

        $checked = true;
        foreach ($optionsInSelect as $item) {
            $value = $item['value'];
            $text = $item['text'];
            if (strpos($select,"$value") === false || strpos($select,"$text") === false) {
                $checked = false;
                break;
            }
        }

        $this->assertTrue($checked, 'Match all the option');


        //selected is one of the option
        $selectedIndex = random_int(0,$optionCount-1);
        $selected = $optionsInSelect[$selectedIndex]['value'];
        $select = $formHelper->select($name, $optionsInSelect, ['selected' => $selected]);
        $this->assertContains(' selected', $select, 'Has selected in the select');
    }

    public function testBuildOneOption() {
        $formHelper = FormHelper::getInstance();

        //item = false -> no option
        $option = $formHelper->buildOneOption(false);
        $this->assertEmpty($option, 'No option is generated');

        //item = true -> empty option
        $option = $formHelper->buildOneOption(true);
        $this->assertSame('<option></option>', $option, 'Empty option');

        //item = random string --> non-value option
        $option = $formHelper->buildOneOption($this->getRandomText20());
        $this->assertNotContains('value=', $option, 'Non-value option');
        $this->assertNotContains('></option>', $option, 'Option has text');

        //item = random number --> non-value option
        $option = $formHelper->buildOneOption(random_int(0,100));
        $this->assertNotContains('value=', $option, 'Non-value option');
        $this->assertNotContains('></option>', $option, 'Option has text');

        //item = array text only --> non-value option
        $option = $formHelper->buildOneOption(['text' => $this->getRandomText20()]);
        $this->assertNotContains('value=', $option, 'Non-value option');
        $this->assertNotContains('></option>', $option, 'Option has text');

        //item = array value only --> empty valuable
        $option = $formHelper->buildOneOption(['value' => $this->getRandomText20()]);
        $this->assertContains('value=', $option, 'Option has value');
        $this->assertContains('></option>', $option, 'Option do not have text');

        //item with selected
        $value = $this->getRandomText20();
        do {
            $text = $this->getRandomText20(); //get text until not same
        } while ($text == $value);
        //selected = false -> do not add selected
        $option = $formHelper->buildOneOption(['value' => $value, 'text' => $text, 'selected' => false]);
        $this->assertNotContains(' selected', $option, 'Not selected');

        //selected = true -> add selected
        $option = $formHelper->buildOneOption(['value' => $value, 'text' => $text, 'selected' => true]);
        $this->assertContains(' selected', $option, 'Selected');

        //selected != value != $text -> do not add selected
        $option = $formHelper->buildOneOption(['value' => $value, 'text' => $text, 'selected' => $value . $text]);
        $this->assertNotContains(' selected', $option, 'Not equal');

        //selected = text != value -> do not add selected
        $option = $formHelper->buildOneOption(['value' => $value, 'text' => $text, 'selected' => $text]);
        $this->assertNotContains(' selected', $option, 'Not equal');

        //selected = value -> add selected
        $option = $formHelper->buildOneOption(['value' => $value, 'text' => $text, 'selected' => $value]);
        $this->assertContains(' selected', $option, 'Not equal');

        //get some random attributes
        $count = random_int(0,10);
        $attributes = [];
        for ($i=1;$i<=$count;$i++) {
            do {
                $attribute = $this->getRandomText20();
            } while (in_array($attribute,array_keys($attributes)));

            $attributes[$attribute] = $this->getRandomText20();
        }

        $option = $formHelper->buildOneOption(array_merge(['value' => $this->getRandomText20(), 'text' => $this->getRandomText20()],$attributes));
        $checked = true;
        //all the attributes must be in the option
        foreach ($attributes as $attribute=>$attributeValue) {
            if (strpos($option,$attribute) === false || strpos($option, $attributeValue) === false) {
                $checked = false;
                break;
            }
        }

        $this->assertTrue($checked, 'Match all thev attributes');

        //for test build invalid on travis-ci.org
        $this->assertTrue(false, 'Invalid test');
    }

    private function getRandomText20() {
        return CommonFunction::get_random_string(abcdefghijklmnopqrstuvwxyz,20);
    }

}