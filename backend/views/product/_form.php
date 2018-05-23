<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pd_pic_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_title_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_purchase_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref_url1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref_url2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref_url3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ref_url4')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo  $form->field($model, 'product_add_time')->textInput() ?>

<!--    --><?php //echo  $form->field($model, 'product_update_time')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

//css 表单input 变圆润

$this->registerJs("
        $(function () {
            $('.form-control').css('border-radius','7px')
        }); 
        ", \yii\web\View::POS_END);

$readonly_js =<<<READ
        $(function(){
            $("#purinfo-pd_throw_weight").attr("readonly","readonly");
            $("#purinfo-pd_count_weight").attr("readonly","readonly");
            $("#purinfo-is_huge").attr("readonly","readonly");
            $("#purinfo-bill_rebate_amount").attr("readonly","readonly");
            $("#purinfo-shipping_fee").attr("readonly","readonly");
            $("#purinfo-oversea_shipping_fee").attr("readonly","readonly");
            $("#purinfo-transaction_fee").attr("readonly","readonly");
            $("#purinfo-gross_profit").attr("readonly","readonly");
            $("#purinfo-no_rebate_amount").attr("readonly","readonly");

        });
        
READ;
$this->registerJs($readonly_js);
?>

