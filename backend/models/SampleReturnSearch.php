<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SampleReturn;

/**
 * SampleReturnSearch represents the model behind the search form of `backend\models\SampleReturn`.
 */
class SampleReturnSearch extends SampleReturn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sample_id', 'back_way', 'has_confirmation', 'submit_merchandiser', 'has_send'], 'integer'],
            [['receipt_address', 'receipt_men', 'receipt_tel', 'back_reason', 'tracking_number', 'express_company',
                'purchaser_memo', 'follower_memo', 'finalcial_memo', 'create_time', 'purchaser_follower_time',
                'follower_submit_time', 'purchaser_finalcial_time', 'finalcial_sure_time',
                'pd_sku', 'sample_sku', 'pd_title','pur_group','purchaser','pic_submit_finance'
            ], 'safe'],
            [['back_money'], 'number'],
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
        $username = Yii::$app->user->identity->username;
        $role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        $query = SampleReturn::find()
            ->select(['
               `pur_info`.pur_info_id,`pur_info`.pd_title,`pur_info`.pur_group,`pur_info`.purchaser,`pur_info`.pd_pic_url,
               `sample`.pay_way,`sample`.pd_sku,`sample`.sample_sku,`sample`.fact_pay_amount,
                `sample_return`.id,`sample_return`.submit_merchandiser,`sample_return`.has_send,
                `sample_return`.has_confirmation,`sample_return`.back_money,`sample_return`.tracking_number,
                `sample_return`.express_company,`sample_return`.purchaser_follower_time,`sample_return`.follower_submit_time,
                `sample_return`.purchaser_finalcial_time,`sample_return`.finalcial_sure_time, `sample_return`.pic_submit_finance',

            ])
            ->joinWith('sample')
            ->joinWith('purinfo')

        ;
        if (array_key_exists('财务',$role)){
           $this->has_confirmation=0;
           $this->pic_submit_finance=1;
        }elseif (array_key_exists('采购A',$role)||array_key_exists('采购B',$role)
            ||array_key_exists('采购主管',$role)){
            $query ->andWhere(['`pur_info`.purchaser'=>$username]);
            $this->submit_merchandiser=0;
        }
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
            'id' => $this->id,
            'sample_id' => $this->sample_id,
            'back_way' => $this->back_way,
            'has_confirmation' => $this->has_confirmation,
            'back_money' => $this->back_money,
            'submit_merchandiser' => $this->submit_merchandiser,
            'has_send' => $this->has_send,
            'create_time' => $this->create_time,
            'purchaser_follower_time' => $this->purchaser_follower_time,
            'follower_submit_time' => $this->follower_submit_time,
            'purchaser_finalcial_time' => $this->purchaser_finalcial_time,
            'finalcial_sure_time' => $this->finalcial_sure_time,
            'pic_submit_finance' => $this->pic_submit_finance,
        ]);

        $query->andFilterWhere(['like', 'receipt_address', $this->receipt_address])
            ->andFilterWhere(['like', 'receipt_men', $this->receipt_men])
            ->andFilterWhere(['like', 'receipt_tel', $this->receipt_tel])
            ->andFilterWhere(['like', 'back_reason', $this->back_reason])
            ->andFilterWhere(['like', 'tracking_number', $this->tracking_number])
            ->andFilterWhere(['like', 'express_company', $this->express_company])
            ->andFilterWhere(['like', 'purchaser_memo', $this->purchaser_memo])
            ->andFilterWhere(['like', 'follower_memo', $this->follower_memo])
            ->andFilterWhere(['like', 'finalcial_memo', $this->finalcial_memo])
            ->andFilterWhere(['like', 'pd_sku', $this->pd_sku])
            ->andFilterWhere(['like', 'pd_group', $this->pur_group])
            ->andFilterWhere(['like', 'sample_sku', $this->sample_sku])
            ->andFilterWhere(['like', 'pd_title', $this->pd_title])
        ;

        return $dataProvider;
    }
}
