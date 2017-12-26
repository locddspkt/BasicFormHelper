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

</body>
</html>
```

**Example Scripts**

<ul>
<li>Basic usage: <strong>./examples/select_example.php</strong></li>
<li>Hidden inputs usage: <strong>./examples/hidden_example.php</strong></li>
</ul>

## Keywords

Forms, User Feedback, Helper, Select, Input, PHP 7 Compatible, PHP 7+.

## License

This project is licensed under the MIT license.
