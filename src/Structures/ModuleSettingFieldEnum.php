<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Structures;

use OZiTAG\Tager\Backend\Core\Enums\Enum;
use OZiTAG\Tager\Backend\Fields\Base\BaseField;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldContract;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldEnumContract;

abstract class ModuleSettingFieldEnum extends Enum implements IModuleSettingsFieldEnumContract
{
    abstract static function field(string $param): ModuleSettingField;

    public static function getParams(): array
    {
        return static::getValues();
    }
}
