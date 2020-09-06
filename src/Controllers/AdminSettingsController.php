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
    private $modelClass;

    /** @var string */
    private $module;
    
    /** @var string|null */
    private $cacheNamespace = null;

    public function __construct($module, $modelClass, $cacheNamespace = null)
    {
        $this->module = $module;

        $this->modelClass = $modelClass;

        $this->cacheNamespace = $cacheNamespace;
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
        return $this->serve(SaveModuleSettingsFeature::class, [
            'modelClass' => $this->modelClass,
            'module' => $this->module,
            'cacheNamespace' => $this->cacheNamespace
        ]);
    }
}
