<?php
/**
 * Created by PhpStorm.
 * User: jenny
 * Date: 2018/5/14
 * Time: 下午12:00
 */

use yii\helpers\Html;
use kartik\select2\Select2;
use kartik\widgets\ActiveForm;

use kartik\builder\Form;


/* @var $this yii\web\View */
/* @var $model backend\models\PurInfo */

?>
<div class="pur-info-update">


    <div class="preview-form">

        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model_update, 'member2')->textInput(['maxlength' => true])->hiddenInput([])->label(false);?>
        <?= $form->field($model_update, 'product_id')->textInput() ->hiddenInput([])->label(false);?>
        <?= $form->field($model_update, 'priview_time')->textInput() ->hiddenInput([])->label(false);?>
        <?= $form->field($model_update, 'member_id')->textInput() ->hiddenInput([])->label(false);?>

        <?php
        echo Form::widget([
            'model'=>$model_update,
            'form'=>$form,
            'columns'=>3,
            'contentBefore'=>'<legend class="text-info"><h3>评审数据记录</h3></legend>',
            'attributes'=>[       // 2 column layout
                'ref_url1'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                'ref_url12'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                'ref_url13'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],

            ]
        ]);

        echo Form::widget([
            'model'=>$model_update,
            'form'=>$form,
            'columns'=>3,
            'attributes'=>[
                'ref_url2'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                'ref_url22'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                'ref_url23'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                'ref_url3'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                'bottom_price'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
                'ref_url4'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],
            ]
        ]);


        echo Form::widget([
            'model'=>$model_update,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[       // 2 column layout
                'content'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'','style'=>'height:150px']],
            ]
        ]);

        ?>
        <?php
        // Usage with ActiveForm and model
        echo $form->field($model_update, 'result')->widget(Select2::classname(), [
            'data' => [
                '0'=>'拒绝',
                '1'=>'采样',
                '2'=>'需议价或谈其他条件',
                '3'=>'未评审',
                '4'=>'直接下单',
                '5'=>'季节产品推迟',
            ],
            'options' => ['placeholder' => '选择结果.....'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

        ?>


        <div class="form-group">
            <div style="text-align:right">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success btn-lg']) ?>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
