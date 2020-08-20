<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Structures;

use OZiTAG\Tager\Backend\Core\Enums\Enum;
use OZiTAG\Tager\Backend\Fields\Base\BaseField;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldContract;

abstract class ModuleSettingField extends Enum implements IModuleSettingsFieldContract
{
    abstract static function field(string $param): Field;

    public static function getParams(): array
    {
        return static::getValues();
    }
}
