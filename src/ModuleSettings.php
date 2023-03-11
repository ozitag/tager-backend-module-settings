<?php

namespace OZiTAG\Tager\Backend\ModuleSettings;

use Illuminate\Foundation\Bus\DispatchesJobs;
use OZiTAG\Tager\Backend\ModuleSettings\Jobs\GetSettingPublicValueJob;

class ModuleSettings
{
    use DispatchesJobs;

    public function getPublicValue($module, $param, $type)
    {
        $job = new GetSettingPublicValueJob($module, $param, $type);
        return $this->dispatchSync($job);
    }
}
