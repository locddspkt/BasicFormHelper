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
        }
        catch (Exception $e) {
            $this->assertEmpty(false, 'An error occurs');
        }


    }
}