# DatePicker

`cinghie\adminlte\widgets\DatePicker` is the date-only companion to `DateTimePicker`. It reuses the same Bootstrap 3/Kartik stack and applies date-only defaults.

## Basic usage

```php
use cinghie\adminlte\widgets\DatePicker;

<?= $form->field($model, 'date')->widget(DatePicker::class) ?>
```

Default date-specific options are:

- `format = yyyy-mm-dd`;
- `minView = 2`.

The shared `DateTimePicker` defaults also apply unless overridden.

## Override defaults

```php
<?= $form->field($model, 'date')->widget(DatePicker::class, [
    'pluginOptions' => [
        'format' => 'dd/mm/yyyy',
        'minView' => 3,
        'autoclose' => false,
    ],
]) ?>
```

Caller-supplied plugin options take precedence over package defaults.

## Validation

The widget does not replace Yii model validation. Validate the accepted date format and normalize values in the model or service layer before persistence.

## Dependency and compatibility

`kartik-v/yii2-widgets` is a runtime dependency because DatePicker and DateTimePicker are public widgets exported by this package.

The current development branch requires PHP 8.1+ and is tested on PHP 8.1 through 8.5.
