<?php

namespace idfly\settings\controllers;

use idfly\settings\Settings;

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
            $model->load(\Yii::$app->request->post(), $class);
            if($model->validate()) {
                $model->save();
                $this->_redirectBack();
            }
        }

        $model->init();

        return $this->render('@vendor/idfly/yii2-settings/views/form', [
            'model' => $model
        ]);
    }
}