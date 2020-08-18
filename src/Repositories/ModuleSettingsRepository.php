<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Repositories;

use OZiTAG\Tager\Backend\Core\Repositories\EloquentRepository;
use OZiTAG\Tager\Backend\ModuleSettings\Models\ModuleSetting;

class ModuleSettingsRepository extends EloquentRepository
{
    public function __construct(ModuleSetting $model)
    {
        parent::__construct($model);
    }

    public function findByModule($module)
    {
        return $this->model::query()->whereModule($module)->get();
    }

    public function findByModuleAndParam($module, $param)
    {
        return $this->model::query()->whereModule($module)->whereParam($param)->first();
    }
}
