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