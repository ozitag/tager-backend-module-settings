<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Contracts;

use OZiTAG\Tager\Backend\ModuleSettings\Structures\ModuleSettingField;

interface IModuleSettingsFieldEnumContract
{
    /** @return string[] */
    public static function getParams(): array;

    public static function field(string $param): ModuleSettingField;
}
