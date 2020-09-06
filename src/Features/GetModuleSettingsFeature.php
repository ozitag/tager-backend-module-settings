<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldEnumContract;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingValueJob;
use OZiTAG\Tager\Backend\ModuleSettings\Structures\ModuleSettingField;

class GetModuleSettingsFeature extends BaseModuleSettingsFeature
{
    public function handle()
    {
        $modelClass = $this->modelClass;

        $reflectionModelClass = new \ReflectionClass($modelClass);
        if ($reflectionModelClass->implementsInterface(IModuleSettingsFieldEnumContract::class) == false) {
            throw new \Exception('modelClass must implements IModuleSettingsFieldEnumContract');
        }

        $keys = $modelClass::getParams();

        $result = [];
        foreach ($keys as $key) {
            $item = [
                'name' => $key
            ];

            /** @var ModuleSettingField $model */
            $model = $modelClass::field($key);
            if (!$model) {
                continue;
            }

            $item = array_merge($item, [
                'label' => $model->getField()->getLabel(),
                'type' => $model->getField()->getType()
            ]);

            $item['value'] = $this->run(GetSettingValueJob::class, [
                'module' => $this->module,
                'param' => $key,
                'type' => $model->getField()->getType()
            ]);

            $result[] = $item;
        }

        return new JsonResource($result);
    }
}
