<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SampleReturnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '样品退回';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sample-return-index">

    <p>
        <?= Html::button('提交跟单', ['id' => 'to-document-attached', 'class' => 'btn btn-primary']) ;?>
        <?=  Html::button('取消提交', ['id' => 'cancel', 'class' => 'btn btn-info']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'sample-fee-back',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            ['class' => 'kartik\grid\CheckboxColumn'],
            ['class' => 'kartik\grid\ActionColumn',
             'template' => '{update} {view}',
            ],
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
            [
                'attribute'=>'submit_merchandiser',
                'value' => function($model) { if($model->submit_merchandiser==1){return '是';}else{ return '否';} },
                'contentOptions'=> ['style' => 'width: 50%; word-wrap: break-word;white-space:pre-line;'],
                'format'=>'html',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['1' => '是', '0' => '否'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'是否提交?'],


            ],
            'tracking_number',
            'express_company',
            [
                'attribute'=>'has_send',
                'value' => function($model) { if($model->has_send==1){return '是';}else{ return '否';} },
                'contentOptions'=> ['style' => 'width: 50%; word-wrap: break-word;white-space:pre-line;'],
                'format'=>'html',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['1' => '是', '0' => '否'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'寄出?'],
            ],
             [
                'attribute'=>'has_confirmation',
                'value' => function($model) { if($model->has_confirmation==1){return '是';}else{ return '否';} },
                'contentOptions'=> ['style' => 'width: 50%; word-wrap: break-word;white-space:pre-line;'],
                'format'=>'html',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>['1' => '是', '0' => '否'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'财务确认退款'],
            ],
            'back_money',
            //'create_time:date',
            'purchaser_follower_time',
            'follower_submit_time',
            'purchaser_finalcial_time',
            'finalcial_sure_time',

        ],
    ]); ?>
</div>
<?php
$submit = Url::toRoute('submit');
$unsubmit = Url::toRoute('cancel');
//提交评审
$is_submit_manager =<<<JS
    $('#to-document-attached').on('click',function() {
            var button = $(this);
            console.log(123);
            button.attr('disabled','disabled');
            var ids = $("#sample-fee-back").yiiGridView("getSelectedRows");
            console.log(ids);
            if(ids.length ==0) alert('请选择产品后再操作!');
            $.ajax({
            url:'{$submit}',
            type:'post',
            data:{id:ids},
            success:function(res){
                if(res=='success') alert('提交成功!');
                 button.attr('disabled',false);
                location.reload();
                /*if(res=='success') {
                     button.attr('disabled',false);
                     $.pjax.reload({container:"#sample-list});  //Reload GridView
                }*/
               

            },
            error: function (jqXHR, textStatus, errorThrown) {
                button.attr('disabled',false);
            }
            
            });
      
    });
//取消提交

    $('#cancel').on('click',function() {
                var button = $(this);
                button.attr('disabled','disabled');
                var ids = $("#sample-fee-back").yiiGridView("getSelectedRows");
                console.log(ids);
                if(ids.length ==0) alert('请选择产品后再操作!');
                $.ajax({
                url:'{$unsubmit}',
                type:'post',
                data:{id:ids},
                success:function(res){
                    if(res=='success') alert('取消成功!');
                    button.attr('disabled',false);
                    location.reload();
                     /*if(res=='success') {
                     button.attr('disabled',false);
                     $.pjax.reload({container:"#sample-hhh-list});  //Reload GridView
               }*/
    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    button.attr('disabled',false);
                }
                
                });
          
        });
JS;



$this->registerJs($is_submit_manager);
?>