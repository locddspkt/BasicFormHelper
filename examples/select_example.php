<?php
require_once __DIR__ . '/../src/autoloader.php';
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

</body>
</html>