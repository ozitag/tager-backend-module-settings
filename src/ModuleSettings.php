<?php

namespace OZiTAG\Tager\Backend\ModuleSettings;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\ServiceProvider;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingPublicValueJob;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingValueJob;

class ModuleSettings
{
    use DispatchesJobs;

    public function getPublicValue($module, $param, $type)
    {
        $job = new GetSettingPublicValueJob($module, $param, $type);
        return $this->dispatchNow($job);
    }
}
