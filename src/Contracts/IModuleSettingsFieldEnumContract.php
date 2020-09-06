<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Contracts;

use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\ModuleSettings\Structures\ModuleSettingField;

interface IModuleSettingsFieldEnumContract
{
    public static function getParams(): array;

    public static function field(string $param): ModuleSettingField;
}
