# BasicFormHelper
[![Build Status](https://api.travis-ci.org/locddspkt/BasicFormHelper.svg?branch=master)](https://travis-ci.org/locddspkt/BasicFormHelper)

**Example Scripts**
```php
<?php 

require_once ('path/to/BasicFormHeler/autoloader.php'); 

$formHelper = BasicFormHelper\FormHelper::getInstance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Basic Form Helper example</title>
</head>
<body>
<?= $formHelper->select('id1', [1, 2, 3]) ?>
<br/>
<?= $formHelper->select('id2', ['value 1' => 'Apple', 'value 2' => 'Orange', 'value 3' => 'Mango']) ?>
<br/>
<?= $formHelper->select('id3', [
    ['value' => 'value 1', 'text' => 'Apple'],
    ['value' => 'value 2', 'text' => 'Orange'],
    ['value' => 'value 3', 'text' => 'Mango']
]) ?>
<br/>
<?= $formHelper->select('id4',
    ['value 1' => 'Apple', 'value 2' => 'Orange', 'value 3' => 'Mango'],
    [
        'class' => 'select',
        'style' => 'width:100px; height:20px',
        'empty' => ['value' => 0, 'text' => 'Please choose one option'],
        'selected' => 'value 2'
    ]
) ?>
<br/>
<?= $formHelper->select('id5', [
    ['value' => 'value 1', 'text' => 'Apple'],
    ['value' => 'value 2', 'text' => 'Orange', 'class' => 'color-orange'],
    ['value' => 'value 3', 'text' => 'Mango']
]) ?>


Hidden texts:<br/>
Empty hidden <?= $formHelper->hidden() ?><br/>
Hidden with name only <?= $formHelper->hidden('hidden1') ?><br/>
Hidden with name and value <?= $formHelper->hidden('hidden2',['value' => 'hidden field']) ?><br/>
Hidden with name and value ('default') <?= $formHelper->hidden('hidden3',['default' => 'hidden field']) ?><br/>
Hidden with some attrubes <?= $formHelper->hidden('hidden4',
    ['value' => 'hidden data'],
    [
        'class' => 'hidden',
        'style' => 'width:100px; height:20px',
    ]
) ?>

<br/>

Empty input <?= $formHelper->input() ?><br/>
Input with name only <?= $formHelper->input('input1') ?><br/>
Input with name and value <?= $formHelper->input('input2',['value' => 'input field']) ?><br/>
Input with name and value ('default') <?= $formHelper->input('input3',['default' => 'input field']) ?><br/>
Input with some attributes <?= $formHelper->input('input4',
    ['value' => 'hidden data'],
    [
        'class' => 'hidden',
        'style' => 'width:100px; height:20px',
    ]
) ?>

<br/>
Empty checkbox <?= $formHelper->checkbox() ?><br/>
Checkbox with name only <?= $formHelper->checkbox('checkbox1') ?> (default value of the xceckbox is 1)<br/>
Checkbox with name and value <?= $formHelper->checkbox('checkbox2', ['value' => 'checkbox field']) ?><br/>
Checkbox with name and value ('default') <?= $formHelper->checkbox('checkbox3', ['default' => 'checkbox field']) ?><br/>
Checkbox with name, value ('default') and hidden value <?= $formHelper->checkbox('checkbox3', ['default' => 'checkbox field', 'hiddenField' => 'off_value']) ?><br/>
Checkbox with some attributes <?= $formHelper->checkbox('checkbox4',
    ['value' => 'checkbox data'],
    [
        'class' => 'checkbox',
        'group' => 'checkbox_group',
    ]
) ?>
<br/>
Checkbox with some options <?= $formHelper->checkbox('checkbox4',
    ['value' => 'checkbox data',
        'checked' => true,
        'disabled' => '0',
    ],
    [
        'class' => 'checkbox',
        'group' => 'checkbox_group',
    ]
) ?>
</body>
</html>
```

**Example Scripts**

<ul>
<li>Basic usage: <strong>./examples/select_example.php</strong></li>
<li>Hidden inputs usage: <strong>./examples/hidden_example.php</strong></li>
<li>Input usage: <strong>./examples/input_example.php</strong></li>
<li>Checkbox usage: <strong>./examples/checkbox_example.php</strong></li>
</ul>

## Keywords

Forms, User Feedback, Helper, Select, Input, PHP 7 Compatible, PHP 7+.

## License

This project is licensed under the MIT license.
