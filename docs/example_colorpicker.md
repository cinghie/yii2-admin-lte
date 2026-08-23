# ColorPicker

`cinghie\adminlte\widgets\ColorPicker` is a Bootstrap 3/AdminLTE 2 color input with a normal text field, live preview, native browser color control and deferred palette.

The submitted value remains the text input value, so it works with ordinary Yii model validation and forms.

## Model-bound usage

```php
use cinghie\adminlte\widgets\ColorPicker;

<?= $form->field($model, 'color')->widget(ColorPicker::class, [
    'label' => 'Color',
]) ?>
```

## Standalone usage

```php
echo ColorPicker::widget([
    'name' => 'accent',
    'value' => '#3c8dbc',
]);
```

## Custom palette

```php
echo ColorPicker::widget([
    'name' => 'accent',
    'palette' => [
        '#3c8dbc',
        '#00a65a',
        '#f39c12',
        '#dd4b39',
    ],
]);
```

Palette values are accepted only when they are valid 3- or 6-digit HEX colors. Three-digit values are normalized to six digits. Invalid values are ignored and never interpolated into inline CSS.

## Input options

Normal Yii input options remain available and are not overwritten by package defaults:

```php
echo ColorPicker::widget([
    'name' => 'accent',
    'options' => [
        'maxlength' => 12,
        'placeholder' => 'Custom HEX',
        'class' => 'my-extra-class',
    ],
]);
```

The widget supplies `maxlength = 32` and `placeholder = #3c8dbc` only when the caller has not provided those options.

## Labels and icon

```php
echo ColorPicker::widget([
    'name' => 'accent',
    'label' => 'Theme color',
    'iconClass' => 'fa fa-paint-brush',
]);
```

`label` is HTML-encoded when rendered. `iconClass` must be a string or `null`.

## Client-side behavior

The palette opens only when requested and closes on outside click or `Escape`. Selecting a swatch or native color updates the text input and triggers its `change` event.

CSS and JavaScript are registered once per page under a shared Yii view key, so rendering multiple ColorPicker instances does not duplicate the global listeners or stylesheet.

## Security

- Palette colors are normalized through a strict HEX validator before they reach an inline style.
- Labels and normal HTML attributes are rendered through Yii helpers.
- Invalid palette entries are skipped.
- Free-form text remains in the text input and is never copied into a style unless it passes HEX validation.

Server-side model validation should still enforce the color format required by the application.
