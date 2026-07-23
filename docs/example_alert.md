Alert Example
=======================

Renders Yii flash messages as AdminLTE / Bootstrap alerts with icons.

```
<?php use cinghie\adminlte\widgets\Alert; ?>

<?= Alert::widget() ?>
```

Set flashes in a controller:

```
Yii::$app->session->setFlash('success', 'Saved successfully.');
Yii::$app->session->setFlash('error', 'Something went wrong.');
Yii::$app->session->setFlash('warning', 'Please review your data.');
Yii::$app->session->setFlash('info', 'FYI …');
```

## Options

```
<?= Alert::widget([
    'closeButton' => [],           // Bootstrap Alert close button options
    'isAjaxRemoveFlash' => true,   // remove flashes during AJAX requests
    // 'alertTypes' => [ ... ],    // override type → class/icon map
    // 'options' => ['class' => ''],
]) ?>
```

Default flash keys: `error`, `danger`, `success`, `info`, `warning`.
