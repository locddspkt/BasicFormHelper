<?php


namespace BasicFormHelper;


use PHPUnit\Framework\TestCase;
use Exception;


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
class FormHelper_Common_Test extends TestCase {
    public function setUp() {
    }

    public function tearDown() {
    }

    public function testGenerateAttributes() {
        $formHelper = FormHelper::getInstance();
        //empty input, return the empty input input

        //invalid input
        $this->assertEmpty($formHelper->generateAttributes(false),'Empty or invalid input');
        $this->assertEmpty($formHelper->generateAttributes(0),'Empty or invalid input');
        $this->assertEmpty($formHelper->generateAttributes(TestUtils::getRandomText20()),'Empty or invalid input');

        //empty
        $this->assertEmpty($formHelper->generateAttributes([]),'Empty input');

        try {
            //get some random attributes
            $count = random_int(0, 10);
            $attributes = [];
            for ($i = 1; $i <= $count; $i++) {
                do {
                    $attribute = TestUtils::getRandomText20();
                } while (in_array($attribute, array_keys($attributes)));

                $attributes[$attribute] = TestUtils::getRandomText20();
            }

            $attributeText = $formHelper->generateAttributes($attributes);

            $checked = true;
            //all the attributes must be in the option
            foreach ($attributes as $attribute => $attributeValue) {
                if (strpos($attributeText, $attribute) === false || strpos($attributeText, $attributeValue) === false) {
                    $checked = false;
                    break;
                }
            }

            $this->assertTrue($checked, 'Match all the attributes');


            //one of the attribute is rejected
            //create rejectedKeys
            $rejectedCount = random_int(1,3);
            $rejectedKeys = [];
            for ($i=1;$i<=$rejectedCount;$i++) $rejectedKeys[] = TestUtils::getRandomText20();

            $attributeCount = random_int(1,50);
            $attributes = [];
            //get attribute until key not in reject
            for ($i = 1; $i<=$attributeCount; $i++) {
                do {
                    $key = TestUtils::getRandomText20();
                } while (in_array($key,$rejectedKeys) || in_array($key, array_keys($attributes)));
                $attributes[$key] = TestUtils::getRandomText20();
            }

            //build
            $attributeText = $formHelper->generateAttributes($attributes,$rejectedKeys);
            $checked = true;
            foreach ($attributes as $attribute => $attributeValue) {
                if (strpos($attributeText, $attribute) === false || strpos($attributeText, $attributeValue) === false) {
                    $checked = false;
                    break;
                }
            }

            $this->assertTrue($checked, 'Match all the attributes');

            //last is one of rejected
            $keyIndex = random_int(0,$rejectedCount-1);

            $attributes[$rejectedKeys[$keyIndex]] = TestUtils::getRandomText20();
            $attributeText = $formHelper->generateAttributes($attributes,$rejectedKeys);

            //do not content the last key
            $this->assertNotContains($rejectedKeys[$keyIndex] . '=', $attributeText);

        }
        catch (Exception $e) {
            $this->assertEmpty(false, 'An error occurs');
        }


    }
}