<?php


namespace backend\controllers;

use Yii;
use backend\models\PurInfo;
use backend\models\JuniorAuditSearch;
use backend\models\Preview;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JuniorAuditController implements the CRUD actions for PurInfo model.
 */
class JuniorAuditController extends Controller
{
    /**
     * {@inheritdoc}
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
        $searchModel = new JuniorAuditSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $leader =  Yii::$app->db->createCommand("
                   select sub_company, leader from `company`
                   ")->queryAll();
        foreach ($leader as $key => $value){
            $leaderArr[] = $value['leader'];
        }
        $preview = Preview::find()
                    ->where(['product_id'=>$id])
                    ->andWhere(['in','member2',$leaderArr])
                    ->one();
        $data = [] ;
        foreach($leader as $key=>$value){
            $data[$value['sub_company']] = $value['leader'];
        }

        $model_update = Preview::find()
            ->where(['product_id'=>$id])
            ->andWhere(['member2' => 'Becky'])
            ->one();
        $exchange_rate = PurInfoController::actionExchangeRate();
        $post = Yii::$app->request->post();
        if($model_update->load($post)) {
                $model_update->view_status = 1;
                $model_update->submit_manager = 1;
                $model_update->priview_time = date('Y-m-d H:i:s');
                if($post['Preview']['result'] == 0){ //Becky 直接拒绝 审核组不要评审了
                  $model->audit_a = 1;
                  $model->save(false);
                }
                $model_update->save(false);
                return $this->redirect(['index']);
            }
            return $this->render('view', [
                'model' => $model,
                'preview' => $preview,
                'model_update' =>$model_update,
                'exchange_rate' =>$exchange_rate,
                'data' =>$data,
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

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['view', 'id' => $model->pur_info_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
     * @throws \yii\db\Exception
     * 提交评审
     */
    public  function  actionSubmit(){
        $username = Yii::$app->user->identity->username;
        $ids = $_POST['id'];
        $product_ids = '';
        foreach ($ids as $k=>$v){
            $product_ids.=$v.',';
        }
        $ids_str = trim($product_ids,',');

        if(isset($ids)&&!empty($ids)){
            $res = Yii::$app->db->createCommand("
            update `preview` set `submit_manager`= 1  where `product_id` in ($ids_str) and  member2='$username' ;
            update `pur_info` set `audit_c` = 1  where `pur_info_id` in ($ids_str)
            ")->execute();
            if($res){
                echo 'success';
            }
        }else{
            echo 'error';
        }
    }


    public  function  actionCancel(){
        $username = Yii::$app->user->identity->username;
        $ids = $_POST['id'];
        $product_ids = '';
        foreach ($ids as $k=>$v){
            $product_ids.=$v.',';
        }
        $ids_str = trim($product_ids,',');

        if(isset($ids)&&!empty($ids)){
            $res = Yii::$app->db->createCommand("
            update `preview` set `submit_manager`= 0  where `product_id` in ($ids_str) and  member2='$username';
            update `pur_info` set `audit_c` = 0 where `pur_info_id` in ($ids_str)
            ")->execute();
            if($res){
                echo 'success';
            }
        }else{
            echo 'error';
        }
    }


}
