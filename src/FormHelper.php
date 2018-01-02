<?php
/**
 * Created by PhpStorm.
 * User: locdd
 * Date: 12/12/17
 * Time: 14:38
 */

namespace BasicFormHelper;

class FormHelper {
    private static $instance = null;

    public static function getInstance() {
        if (empty(self::$instance)) self::$instance = new FormHelper();
        return self::$instance;
    }

    /***
     * @param $fieldName
     * @param $options = list of the item one of these is allow
     *  [value1,value2,value3]
     *  ['value1' => 'text 1','value2' => 'text 2'...]
     *  [['value' => 'value 1','text' => 'text 1, 'attribute1' => 'attrib value']...]
     * @param $attributes = [attrib => value]
     * some attributes is used for other reason
     * 'selected'
     * 'empty' =>
     *      true: --> empty value and empty text
     *      false: --> do not add the empty option
     *      string: -> an empty value with text = string
     *      array['value','text','attrib',...] -> an option
     */
    public function select($fieldName, $options = [], $attributes = []) {
        $definedAttributes = ['selected', 'empty'];

        //1. build begin
        $selectBegin = '<select ';
        if ($fieldName !== false) {
            $selectBegin .= " name='$fieldName' ";
        }

        foreach ($attributes as $attribute => $value) {
            if (in_array($attribute, $definedAttributes)) continue;
            $selectBegin .= " $attribute='$value' ";
        }

        $selected = false;
        if (isset($attributes['selected'])) {
            $selected = $attributes['selected'];
        }

        //selected can not be true
        if ($selected === true) $selected = '1';

        $selectBegin .= '>';

        //2. build options
        $selectOptionData = '';
        //check the empty field
        if (isset($attributes['empty'])) {
            $empty = $attributes['empty'];
            if ($empty === false) {
                //do nothing
            } else if ($empty === true) {
                //add one empty
                $selectOptionData .= $this->buildOneOption($empty) . PHP_EOL;
            } else {
                $selectOptionData .= $this->buildOneOption($empty) . PHP_EOL;
            }
        }
        //other options
        $selectOptionData .= $this->getOptionListFromArray($options, $selected);

        //3. end select
        $selectEnd = '</select>';

        $select = PHP_EOL . $selectBegin . PHP_EOL . $selectOptionData . PHP_EOL . $selectEnd;
        return $select;
    }

    /***
     * return <option value='value' attrubute_1='blabla'>display</option>
     * @param $items supported types
     *  [value1,value2,value3] (no key)
     *  ['value1' => 'text 1','value2' => 'text 2'...] (key and text)
     *  [['value' => 'value 1','text' => 'text 1]...] (no key)
     * @param $selected
     * @param $options array['attribute' => value] for each option
     *
     */
    private function getOptionListFromArray($items, $selected = false) {
        //if $items is not value=>text. use text as value

        $hasKey = self::checkArrayHasKeys($items);

        $optionItems = '';
        $index = 0;
        foreach ($items as $key => $item) {
            //has key
            if ($hasKey) {
                $optionItems .= $this->buildOneOption(['value' => $key, 'text' => $item, 'selected' => $selected]);
            }
            else {
                if (is_array($item)) {
                    $optionItems .= $this->buildOneOption(array_merge($item, ['selected' => $selected]));
                }
                else {
                    $optionItems .= $this->buildOneOption(['text' => $item, 'selected' => $selected]);
                }
            }

            //do not enter and the end of the options
            if ($index++ < count($items) - 1) {
                $optionItems .= PHP_EOL;
            }
        }

        return $optionItems;
    }

    /***
     * @param $item item can be one of this
     * false --> return empty string
     * true --> return empty option
     * string, number -> non-value, text = string
     * array('value','text','other_attribs') don't need to have all, can be 'value' only, 'text' only, 'other_attributes' only
     *  'value' => value of the option
     *  'text' text of the option
     *  'selected' add selected if this value equals to 'value' (set to true or false to force turn on and off
     */
    public function buildOneOption($item) {
        $emptyOption = '<option></option>';
        if ($item === false) return '';
        if ($item === true) return $emptyOption;

        if (is_string($item) || is_numeric($item)) return "<option>$item</option>";

        //item is array or object (do not support object)

        $optionItemBegin = '<option ';

        $value = null;
        if (isset($item['value'])) {
            $value = $item['value'];
            $optionItemBegin .= " value='$value'";
        }

        if (isset($item['selected'])) {
            $selected = $item['selected'];
            if ($selected === true) {
                $optionItemBegin .= ' selected ';
            }
            else if ($selected === false) {
                //do nothing
            }
            else if ($selected == $value) {
                $optionItemBegin .= ' selected ';
            }
        }

        //build options
        foreach ($item as $key=>$value) {
            //do not generate with some defined ['value', 'text', 'selected'];
            if (in_array($key, ['value','text','selected'])) continue;

            $optionItemBegin .= " $key='$value'";
        }

        $optionItemBegin .= '>';

        //build text
        $optionItemDisplay = '';
        if (isset($item['text'])) {
            $optionItemDisplay = $item['text'];
        }

        $optionItemEnd = '</option>';

        return $optionItemBegin . $optionItemDisplay . $optionItemEnd;

    }

    /***
     * @param $list this list of the objects to be used in the select
     * @param null $options (default = ['value' => 'id', 'text' => 'name']
     */
    public static function convertObjectListToOptions($list, $options = null) {
        if (empty($options)) $options = ['value' => 'id', 'text' => 'name'];

        //travel all the list, get only 2 item = id and name
        $valueKey = $options['value'];
        $textKey = $options['text'];

        $newList = [];
        foreach ($list as $item) {
            $item = (array)$item;
            $newList[] = ['value' => $item[$valueKey], 'text' => $item[$textKey]];
        }

        return $newList;
    }

    private static function checkArrayHasKeys($array) {
        if (!is_array($array)) return false;

        if (empty($array)) return false; //em

        $index = 0;
        foreach ($array as $key => $value) {
            if ($key !== $index++) return true;
        }

        return false;
    }


    /***
     * @param $fieldName can be false to ignore the name
     * @param array $options support only one key default or value (the value)
     * @param array $attributes
     */
    public function hidden($fieldName = false, $options = [], $attributes = []) {
        $definedAttributes = [];
        //1. build begin
        $input = '<input';
        if ($fieldName !== false) {
            $input .= " name='$fieldName'";
        }

        $input .= " type='hidden'";

        foreach ($attributes as $attribute => $value) {
            if (in_array($attribute, $definedAttributes)) continue;
            $input .= " $attribute='$value'";
        }

        if (isset($options['value'])) {
            $input .= " value='" . $options['value'] . "'";
        }
        if (isset($options['default'])) {
            $input .= " value='" . $options['default'] . "'";
        }


        $input .= '/>';

        return $input;
    }

    /***
     * @param $fieldName can be false to ignore the name
     * @param array $options support only one key default or value (the value)
     * @param array $attributes
     */
    public function input($fieldName = false, $options = [], $attributes = []) {
        $definedAttributes = [];
        //1. build begin
        $input = '<input';
        if ($fieldName !== false) {
            $input .= " name='$fieldName'";
        }

        $input .= " type='text'";

        foreach ($attributes as $attribute => $value) {
            if (in_array($attribute, $definedAttributes)) continue;
            $input .= " $attribute='$value'";
        }

        if (isset($options['value'])) {
            $input .= " value='" . $options['value'] . "'";
        }
        if (isset($options['default'])) {
            $input .= " value='" . $options['default'] . "'";
        }


        $input .= '/>';

        return $input;
    }

}