<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Contracts;

interface IModuleSettingsFieldContract
{
    public static function getValues();

    public static function model($param);
}
