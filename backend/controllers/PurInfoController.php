<?php

namespace backend\controllers;

use Yii;
use backend\models\PurInfo;
use backend\models\PurInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PurInfoController implements the CRUD actions for PurInfo model.
 */
class PurInfoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PurInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurInfoSearch();

        $username = Yii::$app->user->identity->username;

        if($username=='admin'||$username=='Jenny'){
            $username = '';
        }

//      0销售推荐  1 自主开发
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$username);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurInfo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PurInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PurInfo();

       $rate = $this->actionExchangeRate();

        if ($model->load(Yii::$app->request->post())) {
            $model->preview_status = '待评审';
            $model->purchaser = Yii::$app->user->identity->username;
            $model->save();
            return $this->redirect(['view', 'id' => $model->pur_info_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'exchange_rate' => $rate
        ]);
    }

    /**
     * Updates an existing PurInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $product_id =  $model->parent_product_id;

        $rate = $this->actionExchangeRate();

        if ($model->load(Yii::$app->request->post()) ) {
            //标记产品 已完成
            Yii::$app->db->createCommand("
              update `product` set `complete_status`='已完成'
              WHERE `product_id` = $product_id
              ")->execute();
            $model->preview_status = '待评审';
            $model->save();
            return $this->redirect(['view', 'id' => $model->pur_info_id]);
        }
        return $this->render('update', [
            'model' => $model,
            'exchange_rate' => $rate
        ]);
    }

    /**
     * Deletes an existing PurInfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PurInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PurInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PurInfo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Find exchange rate
     * @return mixed
     * @throws \yii\db\Exception
     */
    static  function actionExchangeRate(){
        $res = Yii::$app->db->createCommand("
        select t1.`exchange_rate` from `yae_exchange_rate`  t1 where t1.`currency`='USD'
        ")->queryOne();
        $rate = $res['exchange_rate'];
        return $rate;
    }



}
