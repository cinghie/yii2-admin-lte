Navbar Button Example
=======================

Navbar link/button (external URL or POST logout, etc.).

## Default Value

```
<?php use cinghie\adminlte\widgets\NavbarButton; ?>

<?= NavbarButton::widget() ?>
```

## External link

```
<?php use cinghie\adminlte\widgets\NavbarButton; ?>

<?= NavbarButton::widget([
    'title' => '<i class="fa fa-external-link"></i>',
    'option' => ['target' => '_blank'],
    'url' => 'https://www.example.com',
]) ?>
```

## URL with method POST

```
<?php
use cinghie\adminlte\widgets\NavbarButton;
use yii\helpers\Url;
?>

<?= NavbarButton::widget([
    'title' => '<i class="fa fa-power-off"></i>',
    'option' => ['data-method' => 'post'],
    'url' => Url::to(['/user/security/logout']),
]) ?>
```

| Property | Default |
|----------|---------|
| `title` | external-link icon HTML |
| `url` | `#` / configured URL |
| `option` | extra HTML options for the anchor |
| `target` | optional target attribute helper |
