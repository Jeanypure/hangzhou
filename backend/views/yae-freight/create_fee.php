<?php
/**
 * Created by PhpStorm.
 * User: YM-sale
 * Date: 2018/7/2
 * Time: 13:09
 */
use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model backend\models\FreightFee */

$this->title = 'Create Freight Fee';
$this->params['breadcrumbs'][] = ['label' => 'Freight Fees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="freight-fee-create">

    <div class="freight-fee-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'freight_id')->hiddenInput()->label(false) ?>


        <?php
        // Usage with ActiveForm and model
        echo $form->field($model, 'description_id')->widget(Select2::classname(), [
            'data' => $fee_category,
            'options' => ['placeholder' => '选择费用.....'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

        ?>

        <?= $form->field($model, 'quantity')->textInput() ?>

        <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true]) ?>

        <?php
        // Usage with ActiveForm and model
        echo $form->field($model, 'currency')->widget(Select2::classname(), [
            'data' => $currency,
            'options' => ['placeholder' => '选择币种.....'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

        ?>

        <?= $form->field($model, 'amount')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

        <?php
        echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[       // 1 column layout
                'remark'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'','style'=>'height:100px']],
            ]
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>








