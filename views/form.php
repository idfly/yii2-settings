<?php use yii\helpers\Html; ?>

<?php $backUrl = \Yii::$app->urlManager->createUrl('admin/' . $this->context->id . '/index'); ?>
<?php $redirectUrl = \Yii::$app->request->get('_redirect'); ?>
<?php if(!empty($redirectUrl)) : ?>
    <?php $backUrl = $redirectUrl; ?>
<?php endif ?>

<section class="panel">
    <div class="panel-heading with-actions clearfix">
        <h2 class="panel-title inline">
            <?= $model->getTitle(); ?>
        </h2>
        <div class="action-list inline to-right">
            <a class="action btn btn-sm btn-primary" href="<?= Html::encode($backUrl) ?>">Отмена</a>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = new \idfly\porto\ActiveForm();
        $form->begin();
        ?>
        <?= $form->errorSummary($model); ?>
        <?php foreach($fields as $attribute => $field) : ?>
            <?= $model->getFormField($form, $attribute, $field); ?>
        <?php endforeach ?>
        <div class="row">
            <div class="col-sm-3 col-sm-offset-3">
                <input type="submit" class="btn btn-success" value="Сохранить">
            </div>
        </div>
        <?php $form->end(); ?>
    </div>
</section>


