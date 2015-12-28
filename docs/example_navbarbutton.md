Navbar Button Example
=======================

## Default Value

```
<?php use cinghie\adminlte\widgets\NavbarButton; ?>

<!-- logo -->
<?= NavbarButton::widget() ?>
```

## Custom Value to external link

```
<?php use cinghie\adminlte\widgets\NavbarButton; ?>

<!-- navbar button to external link -->
<?= NavbarButton::widget([
    'title' => '<i class="fa fa-external-link"></i>',
    'option' => ['target' => '_blank'],
    'url' => 'https://www.google.com'
]) ?>
```

## Custom Value to url with method post

```
<?php use cinghie\adminlte\widgets\NavbarButton; ?>

<!-- navbar button to url with method post -->
<?= NavbarButton::widget([
    'title' => '<i class="fa fa-power-off"></i>',
    'option' => ['data-method' => 'post'],
    'url' => Url::to(['/user/security/logout'])
]) ?>
```
