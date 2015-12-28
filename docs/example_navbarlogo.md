Navbar Logo Example
=======================

## Default Value

```
<?php use cinghie\adminlte\widgets\NavbarLogo; ?>

<!-- logo -->
<?= NavbarLogo::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\NavbarLogo; ?>

<!-- logo -->
<?= NavbarLogo::widget([
    'logo_lg' => 'My Logo',
    'logo_mini' => 'Logo',
    'logo_url' => Yii::$app->homeUrl
]) ?>
```
