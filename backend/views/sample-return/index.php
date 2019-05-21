<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SampleReturnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '样品退回';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-return-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
//        echo  Html::a('Create Sample Return', ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            ['class' => 'kartik\grid\CheckboxColumn'],
           /* ['class' => 'kartik\grid\ActionColumn',
                'header' => '操作',
                'template' => '{update} {view} {return} ',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, [
                            'title' => '付款',
                            'data-toggle' => 'modal',
                            'data-target' => '#pay-modal',
                            'class' => 'data-pay',
                            'data-id' => $key,
                        ] );
                    },
                    'return' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-backward"></span>', $url, [
                            'title' => '确定退款',
                            'data-toggle' => 'modal',
                            'data-target' => '#return-modal',
                            'class' => 'data-return',
                            'data-id' => $key,
                        ] );
                    },
                ],
            ],*/
            ['class' => 'kartik\grid\ActionColumn'],
            [
                'class' => 'yii\grid\Column',
                'headerOptions' => [
                    'width'=>'100'
                ],
                'header' => '图片',
                'content' => function ($model, $key, $index, $column){
                    return "<img src='" .$model->pd_pic_url. "' width='100' height='100'>";


                }
            ],
            [
                'attribute'=>'pd_title',
                'value' => function($model) { return $model->pd_title;},
                'contentOptions'=> ['style' => 'width: 50%; word-wrap: break-word;white-space:pre-line;'],
                'format'=>'html',
                'headerOptions' => [
                    'width'=>'80%'
                ],
            ],
            [
                'attribute'=>'purchaser',
                'value' => function($model) { return $model->purchaser;},
                'format'=>'html',
                'label' => '申请人'
                ,
            ],
            [
                'attribute'=>'pur_group',
                'value' => function($model) {
                     return $model->pur_group;
                },
                'contentOptions'=> ['style' => 'width: 10%; word-wrap: break-word;white-space:pre-line;'],
                'format'=>'html',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['1' => '一部', '2' => '二部'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'部门'],
//                'group'=>true,  // enable grouping

            ],
            [
                'attribute'=>'pd_sku',
                'value' => function($model) { return $model->pd_sku;},
                'label'=>'SKU',
            ],
            [
                'attribute'=>'sample_sku',
                'value' => function($model) { return $model->sample_sku;},
                'label'=>'拿样SKU',
            ],

//            'id',
//            'sample_id',
            'receipt_address',
            'receipt_men',
            'receipt_tel',
            //'back_reason',
            'back_way',
            'tracking_number',
            'express_company',
            'has_confirmation',
            'back_money',
            'submit_merchandiser',
            //'has_send',
            //'purchaser_memo',
            //'follower_memo',
            //'finalcial_memo',
            //'create_time',
            //'purchaser_follower_time',
            //'follower_submit_time',
            //'purchaser_finalcial_time',
            //'finalcial_sure_time',

        ],
    ]); ?>
</div>
