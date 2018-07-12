<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\YaeSupplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yae-supplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>4,
        'contentBefore'=>'<legend class="text-info"><h3>1.供应商基本信息</h3></legend>',
        'attributes'=>[       // 3 column layout
            'supplier_code'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'supplier_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'supplier_address'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],

        ],

    ]);
    echo $form->field($model, 'business_licence')->widget('manks\FileInput', []);
    ?>

    <?php
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>4,
        'contentBefore'=>'<legend class="text-info"><h3>2.开票基本信息</h3></legend>',

        'attributes'=>[       // 3 column layout
            'pd_bill_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'bill_unit'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'bill_type'=>['type'=>Form::INPUT_RADIO_LIST,
                'items'=>['0'=>'16%专票','1'=>'增值税普通普票', '2'=>'3%专票'],
                'options'=>['placeholder'=>'']],
        ],

    ]);
    ?>
    <?php
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>4,
        'contentBefore'=>'<legend class="text-info"><h3>3.相关银行信息</h3></legend>',
        'attributes'=>[       // 3 column layout
            'pay_card'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'pay_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'pay_bank'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            'account_proportion'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],

        ],

    ]);
    ?>
    <div class="col-sm-3">
        <?php
        // Usage with ActiveForm and model
        echo $form->field($model, 'pay_cycleTime_type')->widget(Select2::classname(), [
            'data' => [
                '1'=>'日结',
                '2'=>'周结',
                '3'=>'半月结',
                '4'=>'月结',
                '5'=>'隔月结',
                '0'=>'其他',
            ],
            'options' => ['placeholder' => '支付周期.....'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

    </div>
<!--    1、货到付款。2、款到发货。3、周期结算。4、售后付款。5、默认方式-->
    <div class="col-sm-3">
        <?php
        // Usage with ActiveForm and model
        echo $form->field($model, 'account_type')->widget(Select2::classname(), [
            'data' => [
                '1'=>'货到付款',
                '2'=>'款到发货',
                '3'=>'周期结算',
                '4'=>'售后付款',
                '5'=>'默认方式',
                '0'=>'其他',
            ],
            'options' => ['placeholder' => '供应商结算方式.....'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

    </div>
    <?php
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>4,
        'attributes'=>[       // 3 column layout
            'has_cooperate'=>['type'=>Form::INPUT_RADIO_LIST,
                'items'=>[1=>'是', 0=>'否'],
                'options'=>['placeholder'=>'']],
        ],

    ]);
    echo $form->field($model, 'bank_account_data')->widget('manks\FileInput', []);

    ?>



    <?php
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>6,
        'contentBefore'=>'<legend class="text-info"><h3>5.发票相关</h3></legend>',
        'attributes'=>[       // 3 column layout
            'bill_img1_name_unit'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
        ],

    ]);

    echo $form->field($model, 'bill_img1')->widget('manks\FileInput', []);

    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>4,
        'attributes'=>[       // 3 column layout
            'bill_img2_name_unit'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
        ],

    ]);

    echo $form->field($model, 'bill_img2')->widget('manks\FileInput', []);

    ?>

    <?php
//    echo Form::widget([
//        'model'=>$model,
//        'form'=>$form,
//        'columns'=>6,
//        'contentBefore'=>'<legend class="text-info"><h3>检查</h3></legend>',
//        'attributes'=>[       // 3 column layout
//            'complete_num'=>['type'=>Form::INPUT_TEXT,
//                'options'=>['placeholder'=>'']],'licence_pass'=>['type'=>Form::INPUT_RADIO_LIST,
//                'items'=>[1=>'是', 0=>'否'],
//                'options'=>['placeholder'=>'']],
//            'bill_pass'=>['type'=>Form::INPUT_RADIO_LIST,
//                'items'=>[1=>'是', 0=>'否'],
//                'options'=>['placeholder'=>'']],
//            'bank_data_pass'=>['type'=>Form::INPUT_RADIO_LIST,
//                'items'=>[1=>'是', 0=>'否'],
//                'options'=>['placeholder'=>'']],
//
//        ],
//
//    ]);
    ?>
    <?php
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>4,
        'contentBefore'=>'<legend class="text-info"><h3>其他注意事項</h3></legend>',
        'attributes'=>[       // 3 column layout
            'sup_remark'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'']],

        ],

    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
