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
</body>
</html>