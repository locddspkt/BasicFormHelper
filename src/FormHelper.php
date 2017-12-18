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
     * 'selected_value'
     * 'empty' =>
     *      true: --> empty value and empty text
     *      false: --> do not add the empty option
     *      string: -> an empty value with text = string
     *      array['value','text','attrib',...] -> an option
     */
    public function select($fieldName, $options = [], $attributes = []) {
        $definedAttributes = ['selected_value', 'empty'];

        //1. build begin
        $selectBegin = '<select ';
        if (!empty($fieldName)) {
            $selectBegin .= " name='$fieldName' ";
        }

        foreach ($attributes as $attribute => $value) {
            if (in_array($attribute, $definedAttributes)) continue;
            $selectBegin .= " $attribute='$value' ";
        }

        $selected = false;
        if (isset($attributes['selected_value'])) {
            $selected = $attributes['selected_value'];
        }

        $selectBegin .= '>';

        //2. build options
        $selectOptionData = $this->getOptionListFromArray($options, $selected); //temporary do not support options for
//        $selectOptionData = '';

        //3. end select
        $selectEnd = '</select>';

        $select = $selectBegin . PHP_EOL . $selectOptionData . PHP_EOL . $selectEnd;
        return $select;
    }

    /***
     * return <option value=''>display</option>
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
        foreach ($items as $key => $item) {
            $optionItemBegin = '<option ';

            $value = '';
            $text = '';
            if ($hasKey) {
                $value = $key;
                $text = $item;
            }
            else {
                if (!is_array($item)) {
                    $value = $text = $item;
                }
                else {
                    $value = $item['value'];
                    $text = $item['text'];
                }
            }

            //1. build value
            $optionItemBegin .= " value='$value'";

            //2. build selected
            if ($selected !== false) {
                if ($selected == $value) {
                    $optionItemBegin .= ' selected ';
                }
            }

            //3. build attributes //only when item is array and get all other field except 'value','text'
            if (empty($options)) $options = [];
            foreach ($options as $attribute => $value) {
                $optionItemBegin .= " $attribute='$value' ";
            }

            $optionItemBegin .= '>';
            $optionItemDisplay = $text;
            $optionItemEnd = '</option>';

            $optionItems .= $optionItemBegin . $optionItemDisplay . $optionItemEnd . PHP_EOL;
        }

        return $optionItems;
    }

    /***
     * @param $item item can be one of this
     * false --> return empty string
     * true --> return empty option
     * string, number -> non-value, text = string
     * array('value','text','other_attribs')
     */
    private function buildOneOption($item) {
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
            $selectedValue = $item['selected'];
            if ($selectedValue == $value) {
                $optionItemBegin .= ' selected ';
            }
        }

        //build options

        $optionItemEnd = '</option>';


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
}