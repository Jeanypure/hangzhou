<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SampleReturnSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sample-return-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sample_id') ?>

    <?= $form->field($model, 'receipt_address') ?>

    <?= $form->field($model, 'receipt_men') ?>

    <?= $form->field($model, 'receipt_tel') ?>

    <?php // echo $form->field($model, 'back_reason') ?>

    <?php // echo $form->field($model, 'back_way') ?>

    <?php // echo $form->field($model, 'tracking_number') ?>

    <?php // echo $form->field($model, 'express_company') ?>

    <?php // echo $form->field($model, 'has_confirmation') ?>

    <?php // echo $form->field($model, 'back_money') ?>

    <?php // echo $form->field($model, 'submit_merchandiser') ?>

    <?php // echo $form->field($model, 'has_send') ?>

    <?php // echo $form->field($model, 'purchaser_memo') ?>

    <?php // echo $form->field($model, 'follower_memo') ?>

    <?php // echo $form->field($model, 'finalcial_memo') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'purchaser_follower_time') ?>

    <?php // echo $form->field($model, 'follower_submit_time') ?>

    <?php // echo $form->field($model, 'purchaser_finalcial_time') ?>

    <?php // echo $form->field($model, 'finalcial_sure_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
