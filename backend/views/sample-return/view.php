<?php


use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\SampleReturn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '上传样品费退费图片', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-return-from">
    <?php $form = ActiveForm::begin(); ?>
    <h3>上传样品费退费图片</h3>
    <?php
    echo $form->field($model, 'fee_back_pic')->widget('manks\FileInput', []);
    ?>
    <div class="form-group">
        <?php
        echo Html::submitButton('Save', ['class' => 'btn btn-success btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
