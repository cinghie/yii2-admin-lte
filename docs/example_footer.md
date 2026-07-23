Footer Example
===============

Main footer with copyright and version.

## Default Value

```
<?php use cinghie\adminlte\widgets\Footer; ?>

<?= Footer::widget() ?>
```

## Custom Value

```
<?php use cinghie\adminlte\widgets\Footer; ?>

<?= Footer::widget([
    'copyright_date_start' => '2014',
    'copyright_date_end' => null,   // null → current year
    'copyright_link' => 'https://example.com',
    'copyright_text' => 'Example Corp',
    'version' => '2.4.18',
]) ?>
```

| Property | Default |
|----------|---------|
| `copyright_date_start` | `2014` |
| `copyright_date_end` | current year |
| `copyright_link` | Almsaeed Studio URL |
| `copyright_text` | `Almsaeed Studio` |
| `version` | `2.3.1` |
