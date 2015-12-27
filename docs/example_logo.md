Logo Example
=======================

## Default Value

```
<?php use cinghie\adminlte\widgets\Logo; ?>

<!-- logo -->
<?= Logo::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\Logo; ?>

<!-- logo -->
<?= Logo::widget([
    'logo_lg' => 'My Logo',
    'logo_mini' => 'Logo',
    'logo_url' => Yii::$app->homeUrl
]) ?>
