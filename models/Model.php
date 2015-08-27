<?php

namespace idfly\settings\models;

use idfly\settings\Settings;

abstract class Model extends \yii\base\Model
{
    protected $title = 'Настройки';

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns default form fields for configuration editing
     * @return array
     */
    public static function getFormFields()
    {
        return [];
    }

    /**
     * Load current settings into attributes
     */
    public function init()
    {
        foreach($this->attributes() as $attribute) {
            $this->$attribute = Settings::get(explode('_', $attribute));
        }
    }

    /**
     * Save settings to
     */
    public function save()
    {
        foreach($this->attributes() as $attribute) {
            Settings::set(explode('_', $attribute), $this->{$attribute});
        }
    }
}