<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleSetting extends Model
{
    protected $table = 'tager_module_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'module',
        'param',
        'value'
    ];
}
