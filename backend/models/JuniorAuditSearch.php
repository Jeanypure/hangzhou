<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PurInfo;

/**
 * JuniorAuditSearch represents the model behind the search form of `backend\models\PurInfo`.
 */
class JuniorAuditSearch extends PurInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['audit_c','submit_manager','view_status','submit_leader','pur_info_id', 'pur_group', 'is_huge', 'pd_purchase_num', 'has_shipping_fee', 'bill_tax_rebate', 'parent_product_id', 'source', 'preview_status', 'brocast_status', 'master_result', 'is_submit', 'is_submit_manager', 'pur_group_status', 'junior_submit', 'is_assign', 'audit_a', 'audit_b', 'bill_tax_value', 'pur_complete_status', 'pur_compelte_result', 'has_shared', 'trading_company', 'is_patent_right', 'is_third_party_abroad_right', 'promise_rights', 'special_auth_FDA', 'sample_return', 'is_purchase', 'sample_submit1', 'sample_submit2', 'has_pay', 'is_quality'], 'integer'],
            [['result','purchaser', 'pd_title', 'pd_title_en', 'pd_pic_url', 'pd_package', 'pd_material', 'bill_type', 'hs_code', 'bill_rebate_amount', 'no_rebate_amount', 'retail_price', 'ebay_url', 'amazon_url', 'url_1688', 'else_url', 'shipping_fee', 'oversea_shipping_fee', 'transaction_fee', 'gross_profit', 'remark', 'member', 'assign_member', 'master_member', 'master_mark', 'priview_time', 'pd_create_time', 'purchaser_leader', 'profit_rate', 'gross_profit_amz', 'profit_rate_amz', 'amz_fulfillment_cost', 'selling_on_amz_fee', 'amz_retail_price', 'amz_retail_price_rmb', 'commit_date', 'new_member', 'purchaser_send_time', 'junior_submit_at', 'old_purchaser', 'saler', 'payer', 'sure_purchase_time', 'pay_at', 'submit1_at', 'submit2_at', 'cancel1_at', 'cancel2_at'], 'safe'],
            [['pd_length', 'pd_width', 'pd_height', 'pd_weight', 'pd_throw_weight', 'pd_count_weight', 'pd_pur_costprice', 'ams_logistics_fee', 'old_costprice', 'fact_pay_amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PurInfo::find()
            ->select(['`pur_info`.*,`preview`.view_status,`preview`.submit_manager,`preview`.submit_leader,`preview`.result'])
            ->joinWith('preview')
            ->andWhere(['is_submit'=>1])
            ->andWhere(['member2'=>'Becky'])
            ->orderBy('pur_info_id desc');
        $this->audit_b = 1;
        $this->audit_c = 0;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pur_info_id' => $this->pur_info_id,
            'pur_group' => $this->pur_group,
            'pd_length' => $this->pd_length,
            'pd_width' => $this->pd_width,
            'pd_height' => $this->pd_height,
            'is_huge' => $this->is_huge,
            'pd_weight' => $this->pd_weight,
            'pd_throw_weight' => $this->pd_throw_weight,
            'pd_count_weight' => $this->pd_count_weight,
            'pd_purchase_num' => $this->pd_purchase_num,
            'pd_pur_costprice' => $this->pd_pur_costprice,
            'has_shipping_fee' => $this->has_shipping_fee,
            'bill_tax_rebate' => $this->bill_tax_rebate,
            'parent_product_id' => $this->parent_product_id,
            'source' => $this->source,
            'preview_status' => $this->preview_status,
            'brocast_status' => $this->brocast_status,
            'master_result' => $this->master_result,
            'priview_time' => $this->priview_time,
            'ams_logistics_fee' => $this->ams_logistics_fee,
            'is_submit' => $this->is_submit,
            'pd_create_time' => $this->pd_create_time,
            'is_submit_manager' => $this->is_submit_manager,
            'pur_group_status' => $this->pur_group_status,
            'junior_submit' => $this->junior_submit,
            'is_assign' => $this->is_assign,
            'commit_date' => $this->commit_date,
            'audit_a' => $this->audit_a,
            'audit_b' => $this->audit_b,
            'bill_tax_value' => $this->bill_tax_value,
            'pur_complete_status' => $this->pur_complete_status,
            'pur_compelte_result' => $this->pur_compelte_result,
            'has_shared' => $this->has_shared,
            'old_costprice' => $this->old_costprice,
            'trading_company' => $this->trading_company,
            'purchaser_send_time' => $this->purchaser_send_time,
            'junior_submit_at' => $this->junior_submit_at,
            'is_patent_right' => $this->is_patent_right,
            'is_third_party_abroad_right' => $this->is_third_party_abroad_right,
            'promise_rights' => $this->promise_rights,
            'special_auth_FDA' => $this->special_auth_FDA,
            'sample_return' => $this->sample_return,
            'is_purchase' => $this->is_purchase,
            'sure_purchase_time' => $this->sure_purchase_time,
            'pay_at' => $this->pay_at,
            'fact_pay_amount' => $this->fact_pay_amount,
            'sample_submit1' => $this->sample_submit1,
            'sample_submit2' => $this->sample_submit2,
            'submit1_at' => $this->submit1_at,
            'submit2_at' => $this->submit2_at,
            'cancel1_at' => $this->cancel1_at,
            'cancel2_at' => $this->cancel2_at,
            'has_pay' => $this->has_pay,
            'is_quality' => $this->is_quality,
            'audit_c' =>$this->audit_c,
            'submit_manager' => $this->submit_manager,
            'view_status' => $this->view_status,
            'result' => $this->result
        ]);

        $query->andFilterWhere(['like', 'purchaser', $this->purchaser])
            ->andFilterWhere(['like', 'pd_title', $this->pd_title])
            ->andFilterWhere(['like', 'pd_title_en', $this->pd_title_en])
            ->andFilterWhere(['like', 'pd_pic_url', $this->pd_pic_url])
            ->andFilterWhere(['like', 'pd_package', $this->pd_package])
            ->andFilterWhere(['like', 'pd_material', $this->pd_material])
            ->andFilterWhere(['like', 'bill_type', $this->bill_type])
            ->andFilterWhere(['like', 'hs_code', $this->hs_code])
            ->andFilterWhere(['like', 'bill_rebate_amount', $this->bill_rebate_amount])
            ->andFilterWhere(['like', 'no_rebate_amount', $this->no_rebate_amount])
            ->andFilterWhere(['like', 'retail_price', $this->retail_price])
            ->andFilterWhere(['like', 'ebay_url', $this->ebay_url])
            ->andFilterWhere(['like', 'amazon_url', $this->amazon_url])
            ->andFilterWhere(['like', 'url_1688', $this->url_1688])
            ->andFilterWhere(['like', 'else_url', $this->else_url])
            ->andFilterWhere(['like', 'shipping_fee', $this->shipping_fee])
            ->andFilterWhere(['like', 'oversea_shipping_fee', $this->oversea_shipping_fee])
            ->andFilterWhere(['like', 'transaction_fee', $this->transaction_fee])
            ->andFilterWhere(['like', 'gross_profit', $this->gross_profit])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'member', $this->member])
            ->andFilterWhere(['like', 'assign_member', $this->assign_member])
            ->andFilterWhere(['like', 'master_member', $this->master_member])
            ->andFilterWhere(['like', 'master_mark', $this->master_mark])
            ->andFilterWhere(['like', 'purchaser_leader', $this->purchaser_leader])
            ->andFilterWhere(['like', 'profit_rate', $this->profit_rate])
            ->andFilterWhere(['like', 'gross_profit_amz', $this->gross_profit_amz])
            ->andFilterWhere(['like', 'profit_rate_amz', $this->profit_rate_amz])
            ->andFilterWhere(['like', 'amz_fulfillment_cost', $this->amz_fulfillment_cost])
            ->andFilterWhere(['like', 'selling_on_amz_fee', $this->selling_on_amz_fee])
            ->andFilterWhere(['like', 'amz_retail_price', $this->amz_retail_price])
            ->andFilterWhere(['like', 'amz_retail_price_rmb', $this->amz_retail_price_rmb])
            ->andFilterWhere(['like', 'new_member', $this->new_member])
            ->andFilterWhere(['like', 'old_purchaser', $this->old_purchaser])
            ->andFilterWhere(['like', 'saler', $this->saler])
            ->andFilterWhere(['like', 'payer', $this->payer]);

        return $dataProvider;
    }
}
