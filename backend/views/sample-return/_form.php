<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model backend\models\SampleReturn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sample-return-form">
    <p>
        <img src="<?php echo $purinfo->pd_pic_url ;?>" alt="" width="100" height="100">

    </p>
    <?php $form = ActiveForm::begin(); ?>
    <?php
    echo Form::widget([
    'model'=>$purinfo,
    'form'=>$form,
    'columns'=>6,
    'contentBefore'=>'<legend class="text-info"><h3>1.基本信息</h3></legend>',
    'attributes'=>[       // 3 column layout

        'pur_group'=>['type'=>Form::INPUT_STATIC, 'options'=>['placeholder'=>'']],
        'pd_title'=>['type'=>Form::INPUT_STATIC, 'options'=>['placeholder'=>'']],
        'purchaser'=>['type'=>Form::INPUT_STATIC, 'options'=>['placeholder'=>'']],
    ],
    ]);

    echo Form::widget([
        'model'=>$sample,
        'form'=>$form,
        'columns'=>4,
        'attributes'=>[       // 3 column layout
            'pd_sku'=>['type'=>Form::INPUT_STATIC, 'options'=>['placeholder'=>'']],
            'sample_sku'=>['type'=>Form::INPUT_STATIC, 'options'=>['placeholder'=>'']],
            'pay_way'=>['type'=>Form::INPUT_STATIC, 'options'=>['placeholder'=>'']],
            'pay_amount'=>['type'=>Form::INPUT_STATIC, 'options'=>['placeholder'=>'']],
            'fact_pay_amount'=>['type'=>Form::INPUT_STATIC, 'options'=>['placeholder'=>'']],

        ],
    ]);

    echo Form::widget([
            'model'=>$model,
            'form'=>$form,
             'columns'=>2,
             'attributes'=>[
                     'receipt_address'=>['type'=>Form::INPUT_TEXTAREA]
             ]
    ]);
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>4,
        'attributes'=>[       // 3 column layout
            'receipt_men'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'receipt_tel'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'back_reason'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'back_way'=>['type'=>Form::INPUT_RADIO_LIST,
                    'items'=>[1=>'返回王飞鸟支付宝账号',2=>'返回相应对公账户']],

        ],
        'contentAfter' => '<div ><br> <br></div>'

    ]);
        ?>
    <?php
    echo Form::widget([
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[
                    'purchaser_memo'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'']],
            ]
    ]);
    ?>





    <?= $form->field($model, 'tracking_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'express_company')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'has_send')->textInput() ?>

    <?= $form->field($model, 'has_confirmation')->textInput() ?>

    <?= $form->field($model, 'back_money')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'submit_merchandiser')->textInput() ?>



    <?= $form->field($model, 'follower_memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'finalcial_memo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'purchaser_follower_time')->textInput() ?>

    <?= $form->field($model, 'follower_submit_time')->textInput() ?>

    <?= $form->field($model, 'purchaser_finalcial_time')->textInput() ?>

    <?= $form->field($model, 'finalcial_sure_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
