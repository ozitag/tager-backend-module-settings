<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Jobs;

use Ozerich\FileStorage\Storage;
use OZiTAG\Tager\Backend\Core\Jobs\Job;
use OZiTAG\Tager\Backend\Fields\FieldFactory;
use OZiTAG\Tager\Backend\Fields\TypeFactory;
use OZiTAG\Tager\Backend\ModuleSettings\Repositories\ModuleSettingsRepository;

class SetSettingValueJob extends Job
{
    private $module;

    private $param;

    private $type;

    private $value;

    private $meta;

    public function __construct($module, $param, $type, $value, $meta)
    {
        $this->module = $module;
        $this->param = $param;
        $this->type = $type;
        $this->value = $value;
        $this->meta = $meta;
    }

    public function handle(ModuleSettingsRepository $repository, Storage $storage)
    {
        $model = $repository->findByModuleAndParam($this->module, $this->param);
        if ($model) {
            $repository->set($model);
        }

        $type = TypeFactory::create($this->type);
        $type->setValue($this->value);

        if (isset($this->meta['scenario'])) {
            $type->applyFileScenario($this->meta['scenario']);
        }

        $repository->fillAndSave([
            'module' => $this->module,
            'param' => $this->param,
            'value' => $type->getDatabaseValue()
        ]);
    }
}
