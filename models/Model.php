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

    public function getFormField($form, $attribute, $field)
    {
        if(empty($field['type'])) {
            $field['type'] = 'text';
        }

        if(empty($field['options'])) {
            $field['options'] = [];
        }

        switch($field['type']) {
            case 'textarea':
                $formField =
                    $form->field($this, $attribute)->
                    textarea($field['options']);
                break;
            case 'checkbox':
                $formField =
                    $form->field($this, $attribute)->
                    checkbox($field['options']);
                break;
            case 'text':
                $formField =
                    $form->field($this, $attribute)->
                    textInput($field['options']);
                break;
            default:
                $formField =
                    $form->field($this, $attribute)->
                    textInput($field['options']);
        }

        return $formField;
    }
}