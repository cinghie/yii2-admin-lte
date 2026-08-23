<?php

namespace cinghie\adminlte\widgets;

use kartik\widgets\DateTimePicker as KartikDateTimePicker;

/**
 * Bootstrap 3/AdminLTE 2 date-time picker with the calendar control prepended.
 *
 * This wrapper centralizes package defaults while retaining the complete
 * Kartik DateTimePicker configuration surface for host applications.
 */
class DateTimePicker extends KartikDateTimePicker
{
    public function init()
    {
        $this->type = self::TYPE_COMPONENT_PREPEND;
        $this->removeButton = false;
        $this->pluginOptions = array_merge([
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss',
            'todayHighlight' => true,
        ], $this->pluginOptions);
        parent::init();
    }
}
