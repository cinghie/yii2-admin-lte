# Calendar

The `Calendar` widget integrates the FullCalendar 3 component shipped with AdminLTE 2. Calendar-specific JavaScript and CSS are registered only when the widget is rendered, including the FullCalendar print stylesheet.

## Basic usage

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

Event URLs may be ordinary URL strings or Yii route arrays. Route arrays are normalized with `yii\helpers\Url::to()` before being passed to FullCalendar.

## FullCalendar options

Use `clientOptions` for FullCalendar 3 options:

```php
echo Calendar::widget([
    'id' => 'project-calendar',
    'events' => $events,
    'clientOptions' => [
        'editable' => true,
        'defaultView' => 'agendaWeek',
        'firstDay' => 1,
    ],
]);
```

The default header follows the AdminLTE 2 example: previous/next/today controls on the left, title in the center, and month/week/day views on the right.

The `events` key in `clientOptions` is intentionally ignored. Supply event data through the widget's `events` property so URL and color normalization is always applied.

## AdminLTE draggable-events layout

Enable `showExternalEvents` to reproduce the interactive layout from the official AdminLTE 2 calendar example:

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

The sidebar supports draggable predefined events, optional removal after drop, and creation of new draggable events. Set `showCreateEvent` to `false` if the event-creation controls are not needed.

## Widget properties

- `events`: FullCalendar event arrays. Event `url` accepts a string or Yii route array.
- `clientOptions`: additional FullCalendar 3 options.
- `options`: HTML attributes for the calendar container.
- `showExternalEvents`: enables the AdminLTE draggable-events sidebar.
- `externalEvents`: draggable events with `title` and optional `color`.
- `showCreateEvent`: displays the new-event input and Add button.
- `externalEventsTitle`: sidebar heading.
- `newEventPlaceholder`: placeholder for the new-event input.
- `addEventLabel`: Add button label.
- `removeAfterDropLabel`: label for the remove-after-drop checkbox.
- `removeAfterDrop`: initial checkbox state.

## Security

Event data is serialized with Yii's HTML-safe JSON encoder. Event URLs using `javascript:`, `data:` or `vbscript:` schemes are discarded. Configurable event colors accept only simple CSS color values, and external-event titles and labels are HTML-encoded.

As with any client-side calendar, authorization must still be enforced by server-side controllers and APIs. Calendar visibility must never be treated as an access-control boundary.

## Assets

`CalendarAsset` loads the FullCalendar 3, Moment and jQuery UI files bundled by AdminLTE 2. `CalendarPrintAsset` loads the FullCalendar print stylesheet with `media="print"`. These assets are separate from the main AdminLTE asset bundle so pages without a calendar do not incur the additional calendar cost.
