# Calendar

The `Calendar` widget provides the FullCalendar 3 integration used by AdminLTE 2. The calendar assets are loaded only when the widget is rendered.

```php
use cinghie\adminlte\widgets\Calendar;

echo Calendar::widget([
    'events' => [
        [
            'title' => 'Project meeting',
            'start' => '2026-08-18T10:00:00',
            'end' => '2026-08-18T11:00:00',
            'url' => ['/project/view', 'id' => 42],
            'color' => '#3c8dbc',
        ],
    ],
]);
```

## AdminLTE draggable-events layout

To reproduce the interactive layout from the official AdminLTE 2 calendar example, enable `showExternalEvents`:

```php
echo Calendar::widget([
    'showExternalEvents' => true,
    'externalEvents' => [
        ['title' => 'Lunch', 'color' => '#00a65a'],
        ['title' => 'Meeting', 'color' => '#3c8dbc'],
        ['title' => 'Birthday', 'color' => '#f39c12'],
    ],
    'removeAfterDrop' => false,
    'events' => $events,
    'clientOptions' => [
        'editable' => true,
        'defaultView' => 'month',
    ],
]);
```

Event titles are serialized with Yii's HTML-safe JSON encoder. Unsafe `javascript:`, `data:` and `vbscript:` event URLs are removed, and configurable event colors accept only simple CSS color values.

`clientOptions` are merged with the widget defaults. The `events` option is owned by the PHP `events` property so that event sanitization cannot be bypassed accidentally through `clientOptions`.
