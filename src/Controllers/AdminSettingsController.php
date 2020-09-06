<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Controllers\Controller;
use OZiTAG\Tager\Backend\Core\Resources\SuccessResource;
use OZiTAG\Tager\Backend\ModuleSettings\Features\GetModuleSettingsFeature;
use OZiTAG\Tager\Backend\ModuleSettings\Features\SaveModuleSettingsFeature;

class AdminSettingsController extends Controller
{
    /** @var string */
    private $enumClass;

    /** @var string */
    private $module;

    /** @var string|null */
    private $cacheNamespace = null;

    public function __construct($module, $enumClass, $cacheNamespace = null)
    {
        $this->module = $module;

        $this->enumClass = $enumClass;

        $this->cacheNamespace = $cacheNamespace;
    }

    public function index()
    {
        return $this->serve(GetModuleSettingsFeature::class, [
            'modelClass' => $this->enumClass,
            'module' => $this->module
        ]);
    }

    public function save()
    {
        return $this->serve(SaveModuleSettingsFeature::class, [
            'modelClass' => $this->enumClass,
            'module' => $this->module,
            'cacheNamespace' => $this->cacheNamespace
        ]);
    }
}
