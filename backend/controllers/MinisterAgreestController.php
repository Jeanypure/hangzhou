<?php

namespace backend\controllers;

use backend\models\SampleReturn;
use Yii;
use backend\models\PurInfo;
use backend\models\Sample;
use backend\models\Goodssku;
use backend\models\MinisterAgreestSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MinisterAgreestController implements the CRUD actions for PurInfo model.
 */
class MinisterAgreestController extends Controller
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
        $searchModel = new MinisterAgreestSearch();
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

        $sample_model = Sample::findOne(['sample_id'=>$id]);
        $model = PurInfo::findOne(['pur_info_id'=>$sample_model->spur_info_id]);
        $submit2_at = date('Y-m-d H:i:s');
        $post = Yii::$app->request->post();
        if(isset($sample_model)&&!empty($sample_model)){
            if($sample_model->load($post) ){
               $is_agree =  $post['Sample']['is_agreest'];
                if((int)$is_agree==1){
                    $sample_model->sample_submit2 = 1;
                    $sample_model->submit2_at = $submit2_at;
                    $sample_model->is_agreest=1;
                 }

                 $sample_model->save(false);
                 return $this->redirect(['index']);

             }
            return $this->renderAjax('view', [
                'model' => $model,
                'sample_model' => $sample_model,
            ]);
        }else{
            return $this->render('view', [
                'model' =>$model,
            ]);
        }

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
     * Commit product
     * @throws \yii\db\Exception
     *
     */
    public function actionCommit()
    {
        $ids = $_POST['id'];
        $submit2_at = date('Y-m-d H:i:s');

        $product_ids = '';
        foreach ($ids as $k=>$v){
            $product_ids.=$v.',';
        }
        $ids_str = trim($product_ids,',');

        if(isset($ids_str)&&!empty($ids_str)){
            $res = Yii::$app->db->createCommand("
            update `pur_info` set `sample_submit2`= 1 ,`submit2_at` = '$submit2_at'
            where `pur_info_id` in ($ids_str)
            ")->execute();
            if($res){
                echo 'success';
            }
        }else{
            echo 'error';
        }



    }

    /**
     * Cancel commit product
     * @throws \yii\db\Exception
     */
    public function actionCancel()
    {
        $ids = $_POST['id'];
        $cancel_at = date('Y-m-d H:i:s');

        if(is_string($_POST['id'])){
            $ids = [];
            $ids[] = $_POST['id'];
        }
        $product_ids = '';
        foreach ($ids as $k=>$v){
            $product_ids.=$v.',';
        }
        $ids_str = trim($product_ids,',');

        if(isset($ids_str)&&!empty($ids_str)){
            $res = Yii::$app->db->createCommand("
            update `pur_info` set `sample_submit2`= 0 ,`cancel2_at` = '$cancel_at'
            where `pur_info_id` in ($ids_str)
            ")->execute();
            if($res){
                echo 'success';
            }
        }else{
            echo 'error';
        }


    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     * 确定采购, 1入区组长表   2 入产品档案表goodssku  4 sku_vendor
     *  3 若 source=0 更新樣品表 minister_result=3 推送產品
     */

    public function actionQuality($id)
    {

        $sample_model = Sample::findOne(['sample_id'=>$id]);
        $model = PurInfo::findOne(['pur_info_id'=>$sample_model->spur_info_id]);
        $post = Yii::$app->request->post();
        if($sample_model->load($post)){
            $sample_model->attributes = $post['Sample'];
            $minister_result = $post['Sample']['minister_result'];
            if(isset($post['Sample']['is_purchase'])&&$post['Sample']['is_purchase']==1){ //确定采购 1 近产品档案 2 区域组长3产品状态
                $sample_model->sure_purchase_time = date('Y-m-d H:i:s');
                    try{
                        $sql = " SET @id = $sample_model->spur_info_id;
                            CALL purinfo_to_goodssku (@id);";
                        $res = Yii::$app->db->createCommand($sql)->execute();

                    }catch(\Exception $exception){
                        throw $exception;
                    }
                    $goodsSkuHsele = Yii::$app->db->createCommand("select count(*) as number_record from goodssku where pur_info_id = $id")->queryOne();
                    if(!empty($goodsSkuHsele['number_record'])){
                        $hs_res =  $this->actionUpdateHs($id,$model->hs_code);
                    }
                   if($model->source == 0){//销售推荐 3方改成一致
                        try{
                            Yii::$app->db->createCommand("
                        update sample set minister_result=3, audit_team_result=3,purchaser_result=3 where spur_info_id=$id;
                    ")->execute();
                        }catch(\Exception  $exception){
                            throw $exception;
                        }

                    }else{
                        if((int)$minister_result==$sample_model->purchaser_result){
                            $sample_model->audit_team_result = $minister_result;
                            $sample_model->is_diff = 0;

                        }else{
                            $sample_model->is_diff = 1;
                        }

                    }

                    $count = Yii::$app->db->createCommand("
                            select count(*) as num from headman where product_id=$sample_model->spur_info_id
                            ")->queryOne();

                    if(empty($count['num'])){ //第一次 插入
                        $this->actionToHeadman($sample_model->spur_info_id);
                    }

            }
           //确定退样 到样品表
            if(isset($post['Sample']['sample_return'])&&$post['Sample']['sample_return']==1){
               $sample_return_res = $this->actionToSampleReturn($id,$sample_model->spur_info_id);
            }
            if ($sample_model->save(false)) {
                Yii::$app->getSession()->setFlash('success', '保存成功');
            } else {
                Yii::$app->getSession()->setFlash('error', '保存失败');
            }
            return $this->redirect(['index']);
        }
        return  $this->renderAjax('is_quality', [
            'sample_model' => $sample_model,
        ]);

    }

    /**
     * @param $id
     * @return int
     * @throws \yii\db\Exception
     * 插入到组长评审表中
     */
        public  function actionToHeadman($id){
           $group =  Yii::$app->db->createCommand("
                select pur_group from pur_info where  pur_info_id = $id 
            ")->queryOne();

            $no_site = Yii::$app->db->createCommand("
                select no_site from company where  id= $group[pur_group]
            ")->queryOne();

            $site_arr = explode(',',$no_site['no_site']);
            $site_str = '';
            foreach ($site_arr as $key=>$val){
                $site_str .= "'".$val."',";
            }

            $str_site = trim($site_str,',');
            $men_site = Yii::$app->db->createCommand("
                select  code as purchaser,$id as id,purchaser as site from purchaser where  purchaser in($str_site)
            ")->queryAll();
             $arr =[];
            foreach ($men_site as $key=>$value){
                $arr[] =  array_values($value);
            }
            $table = 'headman';
            $arr_key = ['headman','product_id','site'];
            try{
               $res = Yii::$app->db->createCommand()->batchInsert($table,$arr_key,$arr)->execute();
            }
            catch(Exception $e){
                throw new Exception();
            }

            return $res;
        }

    /**
     * 销售退样到退样表
     *
     */
        public  function  actionToSampleReturn($sample_id,$pur_info_id){
            $model = SampleReturn::findOne(['sample_id'=>$sample_id]);
            if(isset($model->sample_id)&&!empty($model->sample_id)){
                return 1;
            }else{
                $sql = "insert into sample_return (sample_id,pur_info_id) values ($sample_id,$pur_info_id)";
                $intoRes = Yii::$app->db->createCommand($sql)->execute();
            }
            return $intoRes;

        }

    /**
     * @param $id
     * @param $hs_code
     * @return string
     * @throws \yii\db\Exception
     * @memo update goodssku declaration elements key
     */

        public function  actionUpdateHs($id,$hs_code){
            $goodssku = Goodssku::findOne(['pur_info_id'=>$id]);
            $hs_code_sql = "select declaration_elements  from hs_code where  hs_code= '$hs_code'";
            $hs_arr =  Yii::$app->db->createCommand($hs_code_sql)->queryOne();
            $hs_code_arr =  explode(',',$hs_arr['declaration_elements']);
            $column_key = ['declaration_item_key1','declaration_item_key2','declaration_item_key3','declaration_item_key4',
                'declaration_item_key5','declaration_item_key6','declaration_item_key7','declaration_item_key8','declaration_item_key9','declaration_item_key10','declaration_item_key11','declaration_item_key12'];
            if(!empty($hs_code_arr )){
                foreach ($hs_code_arr as $key=>$value){
                    $attri = $column_key[$key];
                    $goodssku->$attri = preg_replace('/\d+\:/','',$value);
                }
                if($goodssku->save(false)){
                    return 'ok';
                }
            }
            return 'not found'.$hs_code;



        }
}
