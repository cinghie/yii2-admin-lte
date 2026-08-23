<?php

namespace cinghie\adminlte\widgets;

/**
 * Bootstrap 3/AdminLTE 2 date-only picker using the shared DateTimePicker stack.
 */
class DatePicker extends DateTimePicker
{
    public function init()
    {
        $this->pluginOptions = array_merge([
            'format' => 'yyyy-mm-dd',
            'minView' => 2,
        ], $this->pluginOptions);
        parent::init();
    }
}
