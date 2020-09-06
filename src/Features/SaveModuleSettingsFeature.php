<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Features;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Features\Feature;
use OZiTAG\Tager\Backend\Core\Resources\FailureResource;
use OZiTAG\Tager\Backend\Core\Resources\SuccessResource;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\HttpCache\HttpCache;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldEnumContract;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingValueJob;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\SetSettingValueJob;
use OZiTAG\Tager\Backend\ModuleSettings\Requests\UpdateSettingsRequest;
use OZiTAG\Tager\Backend\ModuleSettings\Structures\ModuleSettingField;

class SaveModuleSettingsFeature extends BaseModuleSettingsFeature
{
    private $cacheNamespace;

    public function __construct($module, $modelClass, $cacheNamespace)
    {
        $this->cacheNamespace = $cacheNamespace;
        parent::__construct($module, $modelClass);
    }

    public function errorResponse($errors)
    {
        return response([
            'message' => "The given data was invalid.",
            'errors' => $errors
        ], 400);
    }

    public function handle(UpdateSettingsRequest $request, HttpCache $httpCache)
    {
        $modelClass = $this->modelClass;

        $reflectionModelClass = new \ReflectionClass($modelClass);
        if ($reflectionModelClass->implementsInterface(IModuleSettingsFieldEnumContract::class) == false) {
            throw new \Exception('modelClass must implements IModuleSettingsFieldEnumContract');
        }

        $keys = $modelClass::getParams();

        $errors = [];

        foreach ($keys as $key) {
            /** @var ModuleSettingField $model */
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

            $validator = $model->getValidator();
            if ($validator) {
                $validateResult = $validator->validate($value);
                if ($validateResult !== true) {
                    $errors[$key] = $validateResult;
                }
            }
        }

        if (!empty($errors)) {
            return $this->errorResponse($errors);
        }

        foreach ($keys as $key) {

            /** @var ModuleSettingField $model */
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
                'type' => $model->getField()->getType(),
                'meta' => $model->getField()->getMeta(),
                'value' => $value,
            ]);
        }

        if ($this->cacheNamespace) {
            $httpCache->clear($this->cacheNamespace);
        }

        return new SuccessResource();
    }
}
