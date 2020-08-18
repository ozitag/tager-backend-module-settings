<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Jobs;

use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Fields\FieldFactory;
use OZiTAG\Tager\Backend\ModuleSettings\Repositories\ModuleSettingsRepository;

class GetSettingPublicValueJob extends Job
{
    private $module;

    private $param;

    private $type;

    public function __construct($module, $param, $type)
    {
        $this->module = $module;
        $this->param = $param;
        $this->type = $type;
    }

    public function handle(ModuleSettingsRepository $repository)
    {
        $model = $repository->findByModuleAndParam($this->module, $this->param);
        if (!$model) {
            return null;
        }

        $field = FieldFactory::create($this->type);
        $field->setValue($model->value);

        return $field->getPublicValue();
    }
}
