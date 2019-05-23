<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SampleReturn */

$this->title = '跟单退样: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '跟单退样', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '申请';
?>
<div class="sample-return-update">

    <?= $this->render('_form', [
        'model' => $model,
        'purinfo' => $purinfo,
        'sample' => $sample,
    ]) ?>

</div>
