<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingValueJob;

class GetModuleSettingsFeature extends BaseModuleSettingsFeature
{
    public function handle()
    {
        $className = $this->modelClass;

        $keys = $className::getValues();

        $result = [];
        foreach ($keys as $key) {
            $item = [
                'field' => $key
            ];

            $model = $className::model($key);
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
