<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Core\Resources\SuccessResource;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\HttpCache\HttpCache;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldContract;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingValueJob;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\SetSettingValueJob;
use OZiTAG\Tager\Backend\ModuleSettings\Requests\UpdateSettingsRequest;

class SaveModuleSettingsFeature extends BaseModuleSettingsFeature
{
    private $cacheNamespace;

    public function __construct($module, $modelClass, $cacheNamespace)
    {
        $this->cacheNamespace = $cacheNamespace;
        parent::__construct($module, $modelClass);
    }

    public function handle(UpdateSettingsRequest $request, HttpCache $httpCache)
    {
        $modelClass = $this->modelClass;

        $reflectionModelClass = new \ReflectionClass($modelClass);
        if ($reflectionModelClass->implementsInterface(IModuleSettingsFieldContract::class) == false) {
            throw new \Exception('modelClass must implements IModuleSettingsFieldContract');
        }

        $keys = $modelClass::getParams();

        foreach ($keys as $key) {

            /** @var Field $model */
            $model = $modelClass::field($key);
            if (!$model) {
                continue;
            }

            $value = null;
            foreach ($request->values as $requestValue) {
                if ($requestValue['name'] == $key) {
                    $value = $requestValue['value'];
                }
            }

            $this->run(SetSettingValueJob::class, [
                'module' => $this->module,
                'param' => $key,
                'type' => $model->getType(),
                'meta' => $model->getMeta(),
                'value' => $value,
            ]);
        }

        if ($this->cacheNamespace) {
            $httpCache->clear($this->cacheNamespace);
        }

        return new SuccessResource();
    }
}
