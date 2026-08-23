<?php

namespace cinghie\adminlte\widgets;

use kartik\widgets\DateTimePicker as KartikDateTimePicker;

/**
 * Bootstrap 3/AdminLTE 2 date-time picker with package defaults.
 *
 * Defaults remain fully overridable through normal Yii widget configuration.
 */
class DateTimePicker extends KartikDateTimePicker
{
    /** @var int Bootstrap/Kartik input layout used when the caller does not override it. */
    public $type = self::TYPE_COMPONENT_PREPEND;

    /** @var array|bool Disable the remove button by default; callers may override it. */
    public $removeButton = false;

    public function init()
    {
        $this->pluginOptions = array_merge([
            'autoclose' => true,
            'format' => 'yyyy-mm-dd hh:ii:ss',
            'todayHighlight' => true,
        ], $this->pluginOptions);

        parent::init();
    }
}
