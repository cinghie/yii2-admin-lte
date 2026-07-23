Navbar Logo Example
=======================

Brand logo for AdminLTE main header (large + mini variants).

## Default Value

```
<?php use cinghie\adminlte\widgets\NavbarLogo; ?>

<?= NavbarLogo::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\NavbarLogo; ?>

<?= NavbarLogo::widget([
    'logo_lg' => '<b>Corima</b>CRM',
    'logo_mini' => '<b>C</b>RM',
    'logo_url' => Yii::$app->homeUrl,
]) ?>
```

| Property | Default |
|----------|---------|
| `logo_lg` | `<b>Admin</b>LTE` (HTML allowed) |
| `logo_mini` | `<b>A</b>LT` |
| `logo_url` | `Yii::$app->homeUrl` |
