<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Enums;

use OZiTAG\Tager\Backend\Core\Enums\Enum;

abstract class SettingField extends Enum
{
    abstract static function model($value);
}
