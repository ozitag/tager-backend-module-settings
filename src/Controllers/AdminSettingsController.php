<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use OZiTAG\Tager\Backend\Core\Controllers\Controller;
use OZiTAG\Tager\Backend\Core\Resources\SuccessResource;

class AdminSettingsController extends Controller
{
    /** @var string */
    private $modelClass;

    public function __construct($modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function index()
    {
        $className = $this->modelClass;

        $keys = $className::getValues();

        $result = [];
        foreach ($keys as $key) {
            $result[] = $className::model($key);
        }

        return new JsonResource($result);
    }

    public function save()
    {
        return new SuccessResource();
    }
}
