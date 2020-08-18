<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Jobs;

use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Fields\FieldFactory;
use OZiTAG\Tager\Backend\ModuleSettings\Repositories\ModuleSettingsRepository;

class SetSettingValueJob extends Job
{
    private $module;

    private $param;

    private $type;

    private $value;

    public function __construct($module, $param, $type, $value)
    {
        $this->module = $module;
        $this->param = $param;
        $this->type = $type;
        $this->value = $value;
    }

    public function handle(ModuleSettingsRepository $repository)
    {
        $model = $repository->findByModuleAndParam($this->module, $this->param);
        if ($model) {
            $repository->set($model);
        }

        $field = FieldFactory::create($this->type);
        $field->setValue($this->value);

        $repository->fillAndSave([
            'module' => $this->module,
            'param' => $this->param,
            'value' => $field->getDatabaseValue()
        ]);
    }
}
