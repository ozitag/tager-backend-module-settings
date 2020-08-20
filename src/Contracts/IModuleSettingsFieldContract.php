<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Contracts;

use OZiTAG\Tager\Backend\Fields\Base\Field;

interface IModuleSettingsFieldContract
{
    public static function getParams(): array;

    public static function field(string $param): Field;
}
