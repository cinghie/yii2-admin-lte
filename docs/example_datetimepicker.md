# DateTimePicker

`cinghie\adminlte\widgets\DateTimePicker` wraps Kartik's Bootstrap 3 DateTimePicker with defaults suited to AdminLTE 2 while keeping the normal Kartik configuration surface available.

`kartik-v/yii2-widgets` is a runtime dependency of this package so the widget works in clean installations.

## Basic usage

```php
use cinghie\adminlte\widgets\DateTimePicker;

<?= $form->field($model, 'starts_at')->widget(DateTimePicker::class) ?>
```

Default behavior:

- component-prepend Bootstrap layout;
- remove button disabled;
- `autoclose = true`;
- `format = yyyy-mm-dd hh:ii:ss`;
- `todayHighlight = true`.

## Override defaults

All package defaults are overridable through normal Yii widget configuration:

```php
<?= $form->field($model, 'starts_at')->widget(DateTimePicker::class, [
    'type' => DateTimePicker::TYPE_INPUT,
    'removeButton' => [
        'icon' => '<i class="fa fa-times"></i>',
    ],
    'pluginOptions' => [
        'format' => 'dd/mm/yyyy hh:ii',
        'autoclose' => false,
        'todayHighlight' => false,
    ],
]) ?>
```

The wrapper provides defaults only; caller-supplied `type`, `removeButton` and `pluginOptions` win.

## Validation and storage

The widget controls presentation and client-side date selection only. Keep date parsing, timezone normalization and validation in the model/application layer. For persisted timestamps, normalize the submitted value before storage according to the application's timezone policy.

## Compatibility

The current development branch targets PHP 8.1+ and is tested on PHP 8.1 through 8.5. This widget is intentionally Bootstrap 3/AdminLTE 2 compatible.
