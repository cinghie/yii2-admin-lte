<?php

namespace cinghie\adminlte\widgets;

use cinghie\adminlte\CalendarAsset;
use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * AdminLTE 2 FullCalendar widget.
 *
 * Supports the standard calendar and, optionally, the draggable external-event
 * panel used by the official AdminLTE 2 calendar example.
 */
class Calendar extends Widget
{
    /** @var array FullCalendar event objects. */
    public $events = [];

    /** @var array Additional FullCalendar options. */
    public $clientOptions = [];

    /** @var array HTML attributes for the calendar element. */
    public $options = [];

    /** @var bool Render the AdminLTE draggable-events sidebar. */
    public $showExternalEvents = false;

    /** @var array External events, each with title and optional color. */
    public $externalEvents = [];

    /** @var bool Show the event-creation controls. */
    public $showCreateEvent = true;

    /** @var string */
    public $externalEventsTitle = 'Draggable Events';

    /** @var string */
    public $newEventPlaceholder = 'Event Title';

    /** @var string */
    public $addEventLabel = 'Add';

    /** @var string */
    public $removeAfterDropLabel = 'remove after drop';

    /** @var bool */
    public $removeAfterDrop = false;

    public function init()
    {
        parent::init();

        if (!is_array($this->events)) {
            throw new InvalidConfigException('Calendar::events must be an array.');
        }
        if (!is_array($this->clientOptions)) {
            throw new InvalidConfigException('Calendar::clientOptions must be an array.');
        }
        if (!is_array($this->externalEvents)) {
            throw new InvalidConfigException('Calendar::externalEvents must be an array.');
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        Html::addCssClass($this->options, 'cinghie-adminlte-calendar');
    }

    public function run()
    {
        CalendarAsset::register($this->getView());
        $this->registerClientScript();

        $calendar = Html::tag('div', '', $this->options);
        if (!$this->showExternalEvents) {
            return $calendar;
        }

        return Html::tag('div',
            Html::tag('div', $this->renderExternalEvents(), ['class' => 'col-md-3'])
            . Html::tag('div', Html::tag('div', $calendar, ['class' => 'box-body no-padding']), [
                'class' => 'col-md-9 box box-primary',
            ]),
            ['class' => 'row cinghie-calendar-layout']
        );
    }

    protected function renderExternalEvents()
    {
        $items = '';
        foreach ($this->externalEvents as $event) {
            if (is_string($event)) {
                $event = ['title' => $event];
            }
            if (!is_array($event) || !isset($event['title'])) {
                continue;
            }

            $style = '';
            if (isset($event['color']) && $this->isSafeCssColor($event['color'])) {
                $style = 'background-color:' . $event['color'] . ';border-color:' . $event['color'] . ';color:#fff';
            }
            $items .= Html::tag('div', Html::encode((string) $event['title']), [
                'class' => 'external-event',
                'style' => $style,
            ]);
        }

        $body = Html::tag('div', $items, ['id' => $this->getExternalEventsId()]);
        $body .= Html::checkbox($this->getId() . '-drop-remove', $this->removeAfterDrop, [
            'id' => $this->getRemoveCheckboxId(),
            'label' => Html::encode($this->removeAfterDropLabel),
        ]);

        if ($this->showCreateEvent) {
            $body .= Html::tag('hr');
            $body .= Html::tag('div',
                Html::textInput(null, '', [
                    'id' => $this->getNewEventInputId(),
                    'class' => 'form-control',
                    'placeholder' => $this->newEventPlaceholder,
                ]),
                ['class' => 'form-group']
            );
            $body .= Html::button(Html::encode($this->addEventLabel), [
                'id' => $this->getAddEventButtonId(),
                'class' => 'btn btn-primary btn-flat btn-block',
                'type' => 'button',
            ]);
        }

        return Html::tag('div',
            Html::tag('div', Html::tag('h4', Html::encode($this->externalEventsTitle), ['class' => 'box-title']), [
                'class' => 'box-header with-border',
            ]) . Html::tag('div', $body, ['class' => 'box-body']),
            ['class' => 'box box-solid']
        );
    }

    protected function registerClientScript()
    {
        $id = $this->options['id'];
        $selector = '#' . $this->escapeJsSelector($id);
        $options = array_merge([
            'header' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'month,agendaWeek,agendaDay',
            ],
            'buttonText' => ['today' => 'today', 'month' => 'month', 'week' => 'week', 'day' => 'day'],
            'editable' => false,
            'droppable' => $this->showExternalEvents,
            'events' => $this->sanitizeEvents($this->events),
        ], $this->clientOptions);

        // Events are always supplied by the PHP API and cannot be replaced by
        // arbitrary clientOptions accidentally.
        $options['events'] = $this->sanitizeEvents($this->events);

        $json = Json::htmlEncode($options);
        $js = "jQuery(function ($) {\n";

        if ($this->showExternalEvents) {
            $externalSelector = '#' . $this->escapeJsSelector($this->getExternalEventsId());
            $removeSelector = '#' . $this->escapeJsSelector($this->getRemoveCheckboxId());
            $js .= "  function initEvent(el) {\n"
                . "    var eventObject = {title: $.trim(el.text())};\n"
                . "    el.data('eventObject', eventObject);\n"
                . "    el.draggable({zIndex: 1070, revert: true, revertDuration: 0});\n"
                . "  }\n"
                . "  $('" . $externalSelector . " .external-event').each(function () { initEvent($(this)); });\n";

            $options['drop'] = '__CINGHIE_DROP_CALLBACK__';
            $json = Json::htmlEncode($options);
            $json = str_replace('"__CINGHIE_DROP_CALLBACK__"', "function () { if ($('" . $removeSelector . "').is(':checked')) { $(this).remove(); } }", $json);

            if ($this->showCreateEvent) {
                $inputSelector = '#' . $this->escapeJsSelector($this->getNewEventInputId());
                $buttonSelector = '#' . $this->escapeJsSelector($this->getAddEventButtonId());
                $js .= "  $('" . $buttonSelector . "').on('click', function () {\n"
                    . "    var input = $('" . $inputSelector . "');\n"
                    . "    var title = $.trim(input.val());\n"
                    . "    if (!title) { return; }\n"
                    . "    var event = $('<div/>').addClass('external-event bg-blue').text(title);\n"
                    . "    $('" . $externalSelector . "').prepend(event);\n"
                    . "    initEvent(event);\n"
                    . "    input.val('');\n"
                    . "  });\n";
            }
        }

        $js .= "  $('" . $selector . "').fullCalendar(" . $json . ");\n});";
        $this->getView()->registerJs($js);
    }

    protected function sanitizeEvents(array $events)
    {
        $safe = [];
        foreach ($events as $event) {
            if (!is_array($event)) {
                continue;
            }
            if (isset($event['url']) && $this->isUnsafeUrl($event['url'])) {
                unset($event['url']);
            }
            foreach (['backgroundColor', 'borderColor', 'textColor', 'color'] as $key) {
                if (isset($event[$key]) && !$this->isSafeCssColor($event[$key])) {
                    unset($event[$key]);
                }
            }
            $safe[] = $event;
        }

        return $safe;
    }

    protected function isUnsafeUrl($url)
    {
        return is_string($url) && preg_match('#^(?:javascript|data|vbscript)\\s*:#i', ltrim($url));
    }

    protected function isSafeCssColor($color)
    {
        if (!is_string($color)) {
            return false;
        }

        return (bool) preg_match('/^(?:#[0-9a-f]{3,8}|[a-z]{1,20}|rgba?\\(\\s*\\d{1,3}\\s*,\\s*\\d{1,3}\\s*,\\s*\\d{1,3}(?:\\s*,\\s*(?:0|1|0?\\.\\d+))?\\s*\\))$/i', trim($color));
    }

    protected function escapeJsSelector($id)
    {
        return preg_replace('/([^a-zA-Z0-9_-])/', '\\\\$1', (string) $id);
    }

    protected function getExternalEventsId()
    {
        return $this->getId() . '-external-events';
    }

    protected function getRemoveCheckboxId()
    {
        return $this->getId() . '-drop-remove';
    }

    protected function getNewEventInputId()
    {
        return $this->getId() . '-new-event';
    }

    protected function getAddEventButtonId()
    {
        return $this->getId() . '-add-new-event';
    }
}
