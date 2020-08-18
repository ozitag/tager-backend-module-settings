<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Features\Feature;

class BaseModuleSettingsFeature extends Feature
{
    protected $module;

    protected $modelClass;

    public function __construct($module, $modelClass)
    {
        $this->module = $module;

        $this->modelClass = $modelClass;
    }
}
