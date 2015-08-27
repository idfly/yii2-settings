<?php

namespace idfly\settings\controllers;

class Controller extends \idfly\components\AdminController
{
    /**
     * Действие по умолчанию - отобразить форму редактирования и сохранить
     * данные в случае пост-запроса.
     *
     * Отобразит форму
     *
     * @param  string $modelName имя модели настоек
     * @return string
     */
    public function actionEdit($modelName)
    {
        $model = new $modelName;
        if(\Yii::$app->request->isPost) {
            $reflect = new \ReflectionClass($model);
            $class = $reflect->getShortName();
            $model->setAttributes($_POST[$class]);
            if($model->validate()) {
                $model->save();
            }
        }

        $model->init();
        $fields = $modelName::getFormFields();

        return $this->render('@vendor/idfly/yii2-settings/views/form', [
            'model' => $model,
            'fields' => $fields
        ]);
    }
}