<?php

namespace backend\controllers;

use backend\models\PurInfo;
use backend\models\Sample;
use Yii;
use backend\models\SampleReturn;
use backend\models\SampleReturnSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SampleReturnController implements the CRUD actions for SampleReturn model.
 */
class SampleReturnController extends Controller
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
     * Lists all SampleReturn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SampleReturnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SampleReturn model.
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
     * Creates a new SampleReturn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SampleReturn();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SampleReturn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $purinfo = PurInfo::findOne($model->pur_info_id);
        $sample = Sample::findOne($model->sample_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['update','id'=>$model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'purinfo' => $purinfo,
            'sample' => $sample
        ]);
    }

    /**
     * Deletes an existing SampleReturn model.
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
     * Finds the SampleReturn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SampleReturn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SampleReturn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSubmit()
    {
        $ids = $_POST['id'];
        $product_ids = '';
        foreach ($ids as $k => $v) {
            $product_ids .= $v . ',';
        }
        $ids_str = trim($product_ids, ',');
        $time = date('Y-m-d H:i:s');
        if (isset($ids) && !empty($ids)) {
            $res = Yii::$app->db->createCommand("
            update `sample_return` set  submit_merchandiser = 1,purchaser_follower_time='$time' where `id` in ($ids_str);
            ")->execute();
            if ($res) {
                echo 'success';
            }
        } else {
            echo 'error';
        }
    }


    public function actionCancel()
    {

        $ids = $_POST['id'];
        $product_ids = '';
        foreach ($ids as $k => $v) {
            $product_ids .= $v . ',';
        }
        $ids_str = trim($product_ids, ',');

        if (isset($ids) && !empty($ids)) {
            $res = Yii::$app->db->createCommand("
                     update `sample_return` set  submit_merchandiser = 0 where `id` in ($ids_str)
            ")->execute();
            if ($res) {
                echo 'success';
            }
        } else {
            echo 'error';
        }
    }

}

