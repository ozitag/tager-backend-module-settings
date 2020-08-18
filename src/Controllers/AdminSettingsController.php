<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Controllers\Controller;
use OZiTAG\Tager\Backend\Core\Resources\SuccessResource;
use OZiTAG\Tager\Backend\ModuleSettings\Features\GetModuleSettingsFeature;

class AdminSettingsController extends Controller
{
    /** @var string */
    private $modelClass;

    /** @var string */
    private $module;

    public function __construct($module, $modelClass)
    {
        $this->module = $module;

        $this->modelClass = $modelClass;
    }

    public function index()
    {
        return $this->serve(GetModuleSettingsFeature::class, [
            'modelClass' => $this->modelClass,
            'module' => $this->module
        ]);
    }

    public function save()
    {
        return new SuccessResource();
    }
}
