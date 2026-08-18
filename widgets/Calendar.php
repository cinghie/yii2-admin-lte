<?php

namespace cinghie\adminlte\widgets;

use cinghie\adminlte\CalendarAsset;
use cinghie\adminlte\CalendarPrintAsset;
use yii\base\InvalidConfigException;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * AdminLTE 2 FullCalendar widget.
 *
 * Supports the standard calendar and, optionally, the draggable external-event
 * panel used by the official AdminLTE 2 calendar example.
 */
class Calendar extends Widget
{
    public $events = [];
    public $clientOptions = [];
    public $options = [];
    public $showExternalEvents = false;
    public $externalEvents = [];
    public $showCreateEvent = true;
    public $externalEventsTitle = 'Draggable Events';
    public $newEventPlaceholder = 'Event Title';
    public $addEventLabel = 'Add';
    public $removeAfterDropLabel = 'remove after drop';
    public $removeAfterDrop = false;

    public function init()
    {
        foreach (['events', 'clientOptions', 'options', 'externalEvents'] as $property) {
            if (!is_array($this->$property)) {
                throw new InvalidConfigException('Calendar::' . $property . ' must be an array.');
            }
        }

        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        Html::addCssClass($this->options, 'cinghie-adminlte-calendar');
    }

    public function run()
    {
        CalendarAsset::register($this->getView());
        CalendarPrintAsset::register($this->getView());
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
            if (!is_array($event) || !array_key_exists('title', $event)) {
                continue;
            }

            $style = null;
            if (isset($event['color']) && $this->isSafeCssColor($event['color'])) {
                $color = trim($event['color']);
                $style = 'background-color:' . $color . ';border-color:' . $color . ';color:#fff';
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
            $body .= Html::tag('div', Html::textInput(null, '', [
                'id' => $this->getNewEventInputId(),
                'class' => 'form-control',
                'placeholder' => $this->newEventPlaceholder,
            ]), ['class' => 'form-group']);
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
        $selector = '#' . $this->escapeJsSelector($this->options['id']);
        $options = array_merge([
            'header' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'month,agendaWeek,agendaDay',
            ],
            'buttonText' => ['today' => 'today', 'month' => 'month', 'week' => 'week', 'day' => 'day'],
            'editable' => false,
            'droppable' => $this->showExternalEvents,
        ], $this->clientOptions);

        // The PHP events property owns event data so its URL/color normalization
        // cannot be bypassed accidentally through clientOptions.
        $options['events'] = $this->sanitizeEvents($this->events);

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
        } else {
            $json = Json::htmlEncode($options);
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

            if (array_key_exists('url', $event)) {
                $url = $this->normalizeEventUrl($event['url']);
                if ($url === null) {
                    unset($event['url']);
                } else {
                    $event['url'] = $url;
                }
            }

            foreach (['backgroundColor', 'borderColor', 'textColor', 'color'] as $key) {
                if (isset($event[$key])) {
                    if (!$this->isSafeCssColor($event[$key])) {
                        unset($event[$key]);
                    } else {
                        $event[$key] = trim($event[$key]);
                    }
                }
            }
            $safe[] = $event;
        }

        return $safe;
    }

    protected function normalizeEventUrl($url)
    {
        if (is_array($url)) {
            $url = Url::to($url);
        } elseif (!is_string($url)) {
            return null;
        }

        $url = trim($url);
        if ($url === '' || preg_match('#^(?:javascript|data|vbscript)\s*:#i', $url)) {
            return null;
        }

        return $url;
    }

    protected function isSafeCssColor($color)
    {
        if (!is_string($color)) {
            return false;
        }

        return (bool) preg_match('/^(?:#[0-9a-f]{3,8}|[a-z]{1,20}|rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}(?:\s*,\s*(?:0|1|0?\.\d+))?\s*\))$/i', trim($color));
    }

    protected function escapeJsSelector($id)
    {
        return preg_replace('/([^a-zA-Z0-9_-])/', '\\$1', (string) $id);
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
