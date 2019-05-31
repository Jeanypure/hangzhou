<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\Sample */

//$this->title = $model->sample_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Samples'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pur-info-form">
    <p>
        <?php
        $pic_url = "http://eaymall.com{$model->fee_back_pic}";
        ?>
        <img src="<?php echo $pic_url;?>" alt="" width="100" height="100">

    </p>
    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>3,
        'contentBefore'=>'<legend class="text-info"><h3>样品退款审核</h3></legend>',
        'attributes'=>[       // 3 column layout
            'back_money'=>[
                'type'=>Form::INPUT_TEXT,
                'label'=>"<span style = 'color:red'><big>*</big></span>实际退款¥",
                'options'=>['placeholder'=>'',]
            ],
            'has_confirmation'=>[
                'type'=>Form::INPUT_RADIO_LIST,
                'items'=>[1=>'是', 0=>'否'],
                'label'=>"<span style = 'color:red'><big>*</big></span>是否退费到账?",
                'options'=>['placeholder'=>'',]
            ],

            'confirmation_men'=>[
                'type'=>Form::INPUT_HIDDEN,
                'options'=>['placeholder'=>'',]
            ],
        ],

    ]);
    echo Form::widget([
        'model'=>$model,
        'form'=>$form,
        'columns'=>1,
        'attributes'=>[       // 3 column layout
          'finalcial_memo'=>[
                'type'=>Form::INPUT_TEXTAREA,
                'options'=>['placeholder'=>'',]
            ],

        ],

    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn-lg btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


