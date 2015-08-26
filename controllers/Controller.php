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
            $model->save();
        }

        $model->init();
        $fields = $modelName::getFormFields();

        return $this->render('/settings/form', [
            'model' => $model,
            'fields' => $fields
        ]);
    }

}