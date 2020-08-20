<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Features\Feature;
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

        $keys = $modelClass::getValues();

        $result = [];
        foreach ($keys as $key) {
            $item = [
                'name' => $key
            ];

            $model = $modelClass::model($key);
            if (!$model) {
                continue;
            }

            $item = array_merge($item, [
                'label' => $model['label'],
                'type' => $model['type'],
            ]);

            $item['value'] = $this->run(GetSettingValueJob::class, [
                'module' => $this->module,
                'param' => $key,
                'type' => $item['type']
            ]);

            $result[] = $item;
        }

        return new JsonResource($result);
    }
}
