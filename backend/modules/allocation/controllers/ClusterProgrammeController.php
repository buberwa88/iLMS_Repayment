<?php

namespace backend\modules\allocation\controllers;

use Yii;
use backend\modules\allocation\models\ClusterProgramme;
use backend\modules\allocation\models\ClusterProgrammeSearch;
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\allocation\models\ClustProgramme;
use common\components\Controller;
use backend\modules\allocation\models\Model;



/**
 * ClusterProgrammeController implements the CRUD actions for ClusterProgramme model.
 */
class ClusterProgrammeController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $this->layout = "default_main";
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
     * Lists all ClusterProgramme models.
     * @return mixed
     */
    public function actionIndex($id) {
        $searchModel = new ClusterProgrammeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'id' => $id,
                    'cmodel' => \backend\modules\allocation\models\ClusterDefinition::find()->select('is_active')->where(['cluster_definition_id' => $id])->one()
        ]);
    }

    /**
     * Displays a single ClusterProgramme model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ClusterProgramme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*
    public function actionCreate($id) {
        $model = new ClusterProgramme();
        $models = [ new ClusterProgramme];
        if ($model->load(Yii::$app->request->post())) {

            $models = ModelCrusterProgramme::createMultiple(ClusterProgramme::classname());
            ModelCrusterProgramme::loadMultiple($models, Yii::$app->request->post());
            
            // validate all models
            $valid = $model->validate();
            $valid = ModelCrusterProgramme::validateMultiple($models) && $valid;
            
            //if ($valid) {
                //echo "telesphory";
                //exit;
                //$model->save(false);
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    //if ($flag = $model->save(false)) {
                       // echo "teles";
                       // exit;
                        foreach ($models as $ClusterProgramme) {
                            //$ClusterProgramme->programme_id = $model->cluster_programme_id;
                            $ClusterProgramme->programme_id = 1;
                            $ClusterProgramme->created_at =date("Y-m-d H:i:s");
                            $ClusterProgramme->created_by=1;
                            $ClusterProgramme->programme_group_id=$model->programme_group_id;
                            $ClusterProgramme->cluster_definition_id=$model->cluster_definition_id;
                            $ClusterProgramme->academic_year_id=$model->academic_year_id;
                            $ClusterProgramme->programme_category_id=$model->programme_category_id;
                            //$model->programme_id=1;
                            if ((!$flag = $ClusterProgramme->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    //}
                    if ($flag) {
                        $transaction->commit();
                        //return $this->redirect(['view', 'id' => $model->id]);
                        return $this->redirect(['index', 'id' => $model->cluster_definition_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            
        } else {
            return $this->render('create', [
            'model' => $model, 
            'modelsAddress' => (empty($modelsAddress)) ? [new ClusterProgramme] : $modelsAddress,   
            'cluster_id' => $id,
            ]);
        }
    }
    */
    
    public function actionCreate($id)
    {
        //$model = new Items();
        $model = new ClustProgramme;
		$model->scenario = 'clust_programme_add';
        $ClusterProgramme = [new ClusterProgramme];
        if ($model->load(Yii::$app->request->post())  && $model->validate()) {
            
           
            $ClusterProgramme = Model::createMultiple(ClusterProgramme::classname());
            Model::loadMultiple($ClusterProgramme, Yii::$app->request->post());

            // validate all models
            //$valid = $model->validate();
            //$valid = Model::validateMultiple($modelsAddress) && $valid;
            
            //if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                   
                    //if ($flag = $model->save(false)) {
                        foreach ($ClusterProgramme as $ClusterProgramme2) {
							
	$group_programmes = \backend\modules\allocation\models\Programme::getProgrammesByProgrammeGroupId2($ClusterProgramme2->programme_group_id);

            //if ($group_programmes) {
                //$count_success = $count_failure = 0;
                $i=1;
                foreach ($group_programmes as $programme) {
		

			    $ClusterProgramme2->programme_id = $programme->programme_id;
                            $ClusterProgramme2->created_at =date("Y-m-d H:i:s");
                            $ClusterProgramme2->created_by=Yii::$app->user->identity->user_id;
                            $ClusterProgramme2->cluster_definition_id=$model->cluster_definition_id;
                            $ClusterProgramme2->academic_year_id=$model->academic_year_id;
                            $ClusterProgramme2->programme_category_id=$model->programme_category_id; 
                            if(count($group_programmes) > $i){
                            \backend\modules\allocation\models\Programme::insertProgrammes($ClusterProgramme2->programme_group_id,$ClusterProgramme2->programme_id,$ClusterProgramme2->created_at,$ClusterProgramme2->created_by,$ClusterProgramme2->cluster_definition_id,$ClusterProgramme2->academic_year_id,$ClusterProgramme2->programme_category_id,$ClusterProgramme2->programme_priority);
                            }
$i++;
                        }
                        
                        if (! ($flag = $ClusterProgramme2->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        
                //}
	
                        }
                    //}
                    if ($flag) {
                        $transaction->commit();
                       $sms ="Information successful added!";                 
                        Yii::$app->getSession()->setFlash('success', $sms);
                        return $this->redirect(['index', 'id' => $model->cluster_definition_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            //}
        
            
            //-----------------------
            
            
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                //'ClusterProgramme' => (empty($ClusterProgramme)) ? [new ClusterProgramme] : $ClusterProgramme,
				'ClusterProgramme' =>$ClusterProgramme,
                'cluster_id' => $id,
            ]);
        }
    }

    /**
     * Updates an existing ClusterProgramme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                    'success', 'Data Successfully Updated!'
            );
            return $this->redirect(['index', 'id' => $model->programme_category_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ClusterProgramme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $model1 = $this->findModel($id);
        $model1->delete();
        Yii::$app->getSession()->setFlash(
                'success', 'Data Successfully Deleted!'
        );
        return $this->redirect(['index', 'id' => $model->cluster_definition_id]);
    }

    /**
     * Finds the ClusterProgramme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ClusterProgramme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ClusterProgramme::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
