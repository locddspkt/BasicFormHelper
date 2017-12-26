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