<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MangerAuditSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '经理评审');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pur-info-index">

    <h6><?= Html::encode($this->title) ?></h6>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'striped'=>true,
        'responsive'=>true,
        'hover'=>true,
        'export' => false,
        'options' =>['style'=>'overflow:auto; white-space:nowrap;table-layout:fixed'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> '操作',
                'template' => ' {audit} {view}  {delete}',
                'buttons' => [
                    'audit' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-check"></span>', $url, [
                            'title' => '评审',
                            'data-toggle' => 'modal',
                            'data-target' => '#audit-modal',
                            'class' => 'data-audit',
                            'data-id' => $key,
                        ] );
                    },
                ],
                'headerOptions' => ['width' => '100'],

            ],

            [
                'class' => 'yii\grid\Column',
                'headerOptions' => [
                    'width'=>'100'
                ],
                'header' => '图片',
                'content' => function ($model, $key, $index, $column){
                    return "<img src='" .$model['pd_pic_url']. "' width='100' height='100'>";


                }
            ],
            [
                'class' => 'yii\grid\Column',
                'header' => '评审结果',
                'headerOptions' => ['width'=>'100'],
                'content' => function ($model, $key, $index, $column){
                    return  $model['master_result'];
                },
            ],

            [
                'class' => 'yii\grid\Column',
                'header' => '评审内容',
                'headerOptions' => ['width'=>'100'],
                'content' => function ($model, $key, $index, $column){
                    return  $model['master_mark'];
                },
            ],
            [
                'class' => 'yii\grid\Column',
                'header' => '评审状态',
                'headerOptions' => ['width'=>'100'],
                'content' => function ($model, $key, $index, $column){
                    return  $model['preview_status'];
                },
            ],

            'master_result',
            'master_mark',
            'preview_status',
            'Jenny',
            'admin',
            'Max',
            'Heidi',
            'Sue',
            'Bianca',
            'Molly',
            'Betty',
            'John',
//
//            'Jenny-Content',
//            'admin-Content',
//            'Max-Content',
//            'Heidi-Content',
//            'Sue-Content',
//            'Bianca-Content',
//            'Molly-Content',
//            'Betty-Content',
//            'John-Content',
//
            'purchaser',
            'pur_group',
            'pd_title',
            'pd_title_en',
            'pd_package',
            [
                'class' => 'yii\grid\Column',
                'header' => '外包装',
                'headerOptions' => ['style' => 'width:20%'],
                'contentOptions' => ['style' => 'width: 30px;', 'class' => 'text-center'],
                'content' => function ($model, $key, $index, $column){
                    return  $model['pd_package'];
                },
            ],
            'pd_length',
            'pd_width',
            'pd_height',
            'is_huge',
            'pd_weight',
            'pd_throw_weight',
            'pd_count_weight',
            'pd_material',
            'pd_purchase_num',
            'pd_pur_costprice',
            'has_shipping_fee',
            'bill_type',
            'bill_tax_value',
            'hs_code',
            'bill_tax_rebate',
            'bill_rebate_amount',
            'no_rebate_amount',
            'retail_price',
            [
                'class' => 'yii\grid\Column',
                'headerOptions' => [
                    'width'=>'100'
                ],
                'header' => 'Amazon链接',
                'content' => function ($model, $key, $index, $column){
                    if (!empty($model['amazon_url'])) return "<a href='$model[amazon_url]' target='_blank'>".parse_url($model['amazon_url'])['host']."</a>";
                }
            ],
            [
                'class' => 'yii\grid\Column',
                'headerOptions' => [
                    'width'=>'100'
                ],
                'header' => 'eBay链接',
                'content' => function ($model, $key, $index, $column){
                    if (!empty($model['ebay_url'])) return "<a href='$model[ebay_url]' target='_blank'>".parse_url($model['ebay_url'])['host']."</a>";
                }
            ],
            [
                'class' => 'yii\grid\Column',
                'headerOptions' => [
                    'width'=>'100'
                ],
                'header' => '1688链接',
                'content' => function ($model, $key, $index, $column){
                    if (!empty($model['url_1688'])) return "<a href='$model[url_1688]' target='_blank'>".parse_url($model['url_1688'])['host']."</a>";
                }
            ],


            'shipping_fee',
            'oversea_shipping_fee',
            'transaction_fee',
            'gross_profit',
//            'remark',
            [
                'class' => 'yii\grid\Column',
                'header' => '评审状态',
                'headerOptions' => ['width'=>'100'],
                'content' => function ($model, $key, $index, $column){
                    return  $model['remark'];
                },
            ],

//            'parent_product_id',


        ],
    ]); ?>


</div>

<?php
use yii\bootstrap\Modal;
// 评审操作
Modal::begin([
    'id' => 'audit-modal',
    'header' => '<h4 class="modal-title">评审产品</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
    'options'=>[
        'data-backdrop'=>'static',//点击空白处不关闭弹窗
        'data-keyboard'=>false,
    ],
    'size'=> Modal::SIZE_LARGE
]);
Modal::end();
?>



<?php
$requestAuditUrl = Url::toRoute('audit');
$auditJs = <<<JS
        $('.data-audit').on('click', function () {
            $.get('{$requestAuditUrl}', { id: $(this).closest('tr').data('key') },
                function (data) {
                    $('.modal-body').html(data);
                }  
            );
        });
JS;
$this->registerJs($auditJs);

?>

