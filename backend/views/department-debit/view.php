<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\YaeFreight */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '部門貨代', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yae-freight-view">
    <p>
        <img src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$model->image;?>" width="100" height="100" alt="" />
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'bill_to',
            'receiver',
            'shipment_id',
            'pod',
            'pol',
            'etd',
            'eta',
            'remark',
            'to_minister',
            'to_financial',
            'mini_deal',
            'fina_deal',
            'mini_res',
            'fina_res',
        ],
    ]) ?>

</div>
