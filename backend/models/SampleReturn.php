<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%sample_return}}".
 *
 * @property int $id ID
 * @property int $sample_id 样品ID
 * @property string $receipt_address 收货地址
 * @property string $receipt_men 收货人
 * @property string $receipt_tel 收货电话
 * @property string $back_reason 退回原因
 * @property int $back_way 0default 1返回王飞鸟支付宝账号522203852@qq.com 2返回相应对公账户
 * @property string $tracking_number 快递单号
 * @property string $express_company 快递公司
 * @property int $has_confirmation 财务确认到账 0否 1是
 * @property string $back_money 退款金额
 * @property int $submit_merchandiser 是否提交到跟单 0否 1是
 * @property int $has_send 是否寄出 0否 1是
 * @property string $purchaser_memo 采购备注
 * @property string $follower_memo 跟单备注
 * @property string $finalcial_memo 财务备注
 * @property string $create_time 创建时间
 * @property string $purchaser_follower_time 采购提交跟单时间
 * @property string $follower_submit_time 跟单提交单号时间
 * @property string $purchaser_finalcial_time 采购提交财务时间
 * @property string $finalcial_sure_time 财务确定时间
 */
class SampleReturn extends \yii\db\ActiveRecord
{
    public  $pd_title,$pur_group,$pay_way,$purchaser,$pd_sku,$sample_sku,$pd_pic_url,$fact_pay_amount;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sample_return}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pur_info_id','sample_id', 'back_way', 'has_confirmation', 'submit_merchandiser', 'has_send'], 'integer'],
            [['back_money'], 'number'],
            [['create_time', 'purchaser_follower_time', 'follower_submit_time', 'purchaser_finalcial_time', 'finalcial_sure_time'], 'safe'],
            [['receipt_address'], 'string', 'max' => 500],
            [['receipt_men', 'tracking_number', 'express_company'], 'string', 'max' => 30],
            [['receipt_tel'], 'string', 'max' => 20],
            [['back_reason', 'purchaser_memo', 'follower_memo', 'finalcial_memo'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sample_id' => '样品ID',
            'receipt_address' => '收货地址',
            'receipt_men' => '收货人',
            'receipt_tel' => '收货电话',
            'back_reason' => '退回原因',
            'back_way' => '退回方式',
            'tracking_number' => '快递单号',
            'express_company' => '快递公司',
            'has_confirmation' => '财务确认到账?',
            'back_money' => '退款金额',
            'submit_merchandiser' => '提交到跟单?',
            'has_send' => '跟单是否寄出?',
            'purchaser_memo' => '采购备注',
            'follower_memo' => '跟单备注',
            'finalcial_memo' => '财务备注',
            'create_time' => '创建时间',
            'purchaser_follower_time' => '采购提交跟单时间',
            'follower_submit_time' => '跟单提交单号时间',
            'purchaser_finalcial_time' => '采购提交财务时间',
            'finalcial_sure_time' => '财务确定时间',
            //pur_info
            'purchaser' => '采购人',
            'pur_group' => '部门号',
            'pd_title' => '中文简称',
           //sample
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     * 关联退样表
     */
    public function getSample(){
        return $this->hasOne(Sample::className(),['sample_id' => 'sample_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * 关联产品信息表
     */
    public function getPurinfo()
    {
        return $this->hasMany(PurInfo::className(), ['pur_info_id' => 'pur_info_id']);
    }
}
