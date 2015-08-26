<?php

namespace idfly\settings\models;

use idfly\settings\Settings;

abstract class Model extends \yii\base\Model {

    protected $keys = []; // where to save or load attributes

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
        foreach($this->keys as $key) {
            $this->$key = Settings::get($key);
        }
    }

    /**
     * Save settings to
     */
    public function save()
    {
        foreach($this->attributes() as $attribute) {
            Settings::set($attribute, $this->{$attribute});
        }
    }

}