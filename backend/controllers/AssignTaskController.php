<?php

namespace backend\controllers;

use Yii;
use backend\models\PurInfo;
use backend\models\AssignTaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * assignTaskController implements the CRUD actions for PurInfo model.
 */
class AssignTaskController extends Controller
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
        $searchModel = new AssignTaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['view', 'id' => $model->pur_info_id]);
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pur_info_id]);
        }

        return $this->render('update', [
            'model' => $model,
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



    public  function actionTask(){
        $ids = $_POST['id'];
        Yii::$app->session['ids']=$ids;
        echo '选择了'.count($ids).'个产品请分配!';
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * 选择采购
     */
    public function actionPickMember()
    {

        $audit_member = Yii::$app->db->createCommand("
                            SELECT p.`purchaser` from `purchaser` p  WHERE  p.`role` =1
                         ")->queryAll();

        $model = new PurInfo();

        if ($model->load(Yii::$app->request->post()) ) {
            $member = Yii::$app->request->post()["PurInfo"]["saler"];
            if(!empty(Yii::$app->session['ids'])){
                $pur_info_ids =  Yii::$app->session['ids'];
                $pur_ids = '';
                foreach ($pur_info_ids as $key=>$value){
                    $pur_ids.=$value.',';

                }
                $ids_str = rtrim($pur_ids,',');
            }
            $pur_group = Yii::$app->db->createCommand("SELECT sub_company from company WHERE leader= '$member'")
                        ->queryOne();
            try{
                $result = Yii::$app->db->createCommand(" 
                            update `pur_info` set `saler`= '$member',`pur_group`= $pur_group[sub_company],`is_assign`=1
                            where pur_info_id in ($ids_str);")->execute();
            }catch(Exception $e){
                throw new Exception();
            }

            $table = 'preview';
            $arr_key = ['member2','product_id'];
            $member2 = [$member];
            $arr = [];
            foreach ($pur_info_ids as $key=>$value){
                $val = [$value];
                $new_array = array_merge($member2,$val);
                $arr[] = $new_array;
                array_push($arr,['Becky',$value]);
            }

            $count_num = Yii::$app->db->createCommand("
            select count(*) as number from `preview` where `product_id` in ($ids_str) 
            and `member2` in ( SELECT p.`purchaser` from `purchaser` p  WHERE  p.`role` =1 or p.`role`=2 )
            ")->queryOne();

            if($count_num['number']!= 0){ //更新原来的member2 杭州经理和杭州销售
                $preview_id = Yii::$app->db->createCommand("
            select preview_id from `preview` where `product_id` in ($ids_str) 
            and `member2` in ( SELECT p.`purchaser` from `purchaser` p  WHERE  p.`role` =1 or p.`role`=2)")->queryAll();
                if(!empty($preview_id)){
                    $preid = '';
                    $previewid = '';
                    foreach ($preview_id as $k=>$v){
                        $previewid .= $v['preview_id'].',';
                    }
                    $preid  = rtrim($previewid,',');
                }

                try{//分配的同时 preview无此产品 插入  存在则更新preview表
                    $update_member = Yii::$app->db->createCommand("
                    update `pur_info` set `saler`= '$member' ,`is_assign`=1   where pur_info_id in ($ids_str);
                    ")->execute();
                    //TODO 重新分配 在销售部中间分配
                    $preview_member2 = Yii::$app->db->createCommand("
                    update `preview` set `member2`= '$member'  where preview_id in  ($preid) and `member2` not in ('$member','Becky');
                    ")->execute();
                }
                catch(Exception $e){
                    throw new Exception();
                }
            }else{//插入新记录
                try{//分配的同时 preview无此产品 插入  存在则更新preview表
                    $res = Yii::$app->db->createCommand()->batchInsert($table,$arr_key,$arr)->execute();
                }catch(Exception $e){
                    throw new Exception();
                }
            }
          if(empty($result)){
              unset(Yii::$app->session['ids']);
          }
            return $this->redirect(['index']);
        }

        $mem=[];
        foreach($audit_member as $k=>$v){
            $mem[$v['purchaser']] = $v['purchaser'];
        }
        return $this->renderAjax('pick_member', [
            'model' => $model,
            'member'=>$mem
        ]);




    }




}
