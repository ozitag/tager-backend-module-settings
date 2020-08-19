<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Core\Resources\SuccessResource;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingValueJob;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\SetSettingValueJob;
use OZiTAG\Tager\Backend\ModuleSettings\Requests\UpdateSettingsRequest;

class SaveModuleSettingsFeature extends BaseModuleSettingsFeature
{
    public function handle(UpdateSettingsRequest $request)
    {
        $className = $this->modelClass;
        $keys = $className::getValues();

        foreach ($keys as $key) {
            $model = $className::model($key);
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
                'type' => $model['type'],
                'value' => $value,
                'meta' => $model['meta'] ?? []
            ]);
        }

        return new SuccessResource();
    }
}
