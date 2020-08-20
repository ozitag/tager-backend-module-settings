<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldContract;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingValueJob;

class GetModuleSettingsFeature extends BaseModuleSettingsFeature
{
    public function handle()
    {
        $modelClass = $this->modelClass;

        $reflectionModelClass = new \ReflectionClass($modelClass);
        if ($reflectionModelClass->implementsInterface(IModuleSettingsFieldContract::class) == false) {
            throw new \Exception('modelClass must implements IModuleSettingsFieldContract');
        }

        $keys = $modelClass::getParams();

        $result = [];
        foreach ($keys as $key) {
            $item = [
                'name' => $key
            ];

            /** @var Field $model */
            $model = $modelClass::field($key);
            if (!$model) {
                continue;
            }

            $item = array_merge($item, [
                'label' => $model->getLabel(),
                'type' => $model->getType()
            ]);

            $item['value'] = $this->run(GetSettingValueJob::class, [
                'module' => $this->module,
                'param' => $key,
                'type' => $model->getType()
            ]);

            $result[] = $item;
        }

        return new JsonResource($result);
    }
}
