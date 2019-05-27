<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SampleReturn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sample Returns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-return-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sample_id',
            'receipt_address',
            'receipt_men',
            'receipt_tel',
            'back_reason',
            'back_way',
            'tracking_number',
            'express_company',
            'has_confirmation',
            'back_money',
            'submit_merchandiser',
            'has_send',
            'purchaser_memo',
            'follower_memo',
            'finalcial_memo',
            'create_time',
            'purchaser_follower_time:datetime',
            'follower_submit_time:datetime',
            'purchaser_finalcial_time:datetime',
            'finalcial_sure_time:datetime',
        ],
    ]) ?>

</div>
