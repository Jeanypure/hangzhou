<?php

namespace backend\modules\bargain\models;

use Yii;

/**
 * This is the model class for table "{{%tb_vendor_detail}}".
 *
 * @property int $id 供应商ID
 * @property string $internalid NS供应商内部ID
 * @property string $supplier_code 供应商简称代码
 * @property string $supplier_name 供应商名称
 * @property string $contact_qq 联系姓名
 * @property string $contact_tel 联系电话
 * @property string $contact_name QQ
 * @property string $bill_type 开票类型 0 16%专票  1增值税普通发票  2  3%专票
 * @property string $date_create 创建日期
 * @property string $date_update 更新时间
 */
class VendorDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tb_vendor_detail}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create', 'date_update'], 'safe'],
            [['internalid'], 'string', 'max' => 11],
            [['supplier_code', 'contact_tel', 'contact_name'], 'string', 'max' => 32],
            [['supplier_name'], 'string', 'max' => 64],
            [['contact_qq'], 'string', 'max' => 16],
            [['bill_type'], 'string', 'max' => 30],
            [['supplier_code'], 'unique'],
            [['supplier_name'], 'unique'],
            [['supplier_code', 'supplier_name'], 'unique', 'targetAttribute' => ['supplier_code', 'supplier_name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'internalid' => 'Internalid',
            'supplier_code' => 'Supplier Code',
            'supplier_name' => 'Supplier Name',
            'contact_qq' => 'Contact Qq',
            'contact_tel' => 'Contact Tel',
            'contact_name' => 'Contact Name',
            'bill_type' => 'Bill Type',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }
}
