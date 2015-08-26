<?php

namespace idfly\settings;

abstract class Model extends \yii\base\Model {

    protected $key = []; // where to save or load attributes

    /**
     * Returns default form fields for configuration editing
     * @return array
     */
    public static function getFormFields()
    {

    }

    /**
     * Load current settings into attributes
     */
    public function init()
    {

    }

    /**
     * Save settings to
     */
    public function save()
    {

    }

}