<?php

namespace OZiTAG\Tager\Backend\ModuleSettings\Structures;

use OZiTAG\Tager\Backend\Core\Enums\Enum;
use OZiTAG\Tager\Backend\Fields\Base\BaseField;
use OZiTAG\Tager\Backend\Fields\Base\Field;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsFieldContract;
use OZiTAG\Tager\Backend\ModuleSettings\Contracts\IModuleSettingsValidator;

class ModuleSettingField
{
    /** @var Field */
    private $field;

    /** @var IModuleSettingsValidator|null */
    private $validator;

    public function __construct(Field $field, ?IModuleSettingsValidator $validator = null)
    {
        $this->field = $field;

        $this->validator = $validator;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function getField()
    {
        return $this->field;
    }

}
