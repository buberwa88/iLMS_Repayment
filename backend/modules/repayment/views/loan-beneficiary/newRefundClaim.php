<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\application\models\ApplicantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loanees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php  echo $this->render('_search_refund', ['model' => $searchModel]); ?>
    <br/>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute' => 'olevel_index',
				'header'=>'Form IV Indexno',
                'value' => function ($model) {	
                $educationDetails = array();	
                $num=0;				
				foreach ($model->applications as $appEduDetails) {						
						foreach ($appEduDetails->educations as $appeducation) {
						//$educationDetails[] = $appeducation->application_id;
						$educationDetails =$appeducation->olevel_index;
                        }						
                    }
					return $educationDetails;
					//return implode("\n", $edudetails);
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'firstname',
				'header'=>'First Name',
                'value' => function ($model) {
                    return $model->user->firstname;
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'middlename',
				'header'=>'Middle Name',
                'value' => function ($model) {
                    return $model->user->middlename;
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'surname',
				'header'=>'Last Name',
                'value' => function ($model) {
                    return $model->user->surname;
                },
				'filter'=>'',
            ],
			/*
			[
                'attribute' => 'NID',
				'header'=>'National Identification No.',
                'value' => function ($model) {
                    return $model->NID;
                },
				'filter'=>'',
            ],
             */			

            [
                'attribute' => 'sex',
				'header'=>'Sex',
                'value' => function ($model) {
				    if($model->sex=='M'){
					$sex="Male";
					}else if($model->sex=='F'){
					$sex="Female";
					}else{
					$sex="Not set";
					}
				     
                    return $sex;
                },
				'filter'=>'',
            ],

            [
                'attribute' => 'date_of_birth',
				'header'=>'Birth Date',
                'value' => function ($model) {	
                    if($model->date_of_birth=='0000-00-00'){
					$results="Not Set";
					}else{				
                    $results=$model->date_of_birth;
					}
					return $results;
                },
				'filter'=>'',
            ],						
            
			[
                'attribute' => 'learning_institution_id',
				'header'=>'Learning Institution',
                'value' => function ($model) {	
                $institutionDetails = array();	
                $num=0;				
				foreach ($model->applications as $appEduDetails2) {						
						foreach ($appEduDetails2->educations as $appLearningIns) {
						//$educationDetails[] = $appeducation->application_id;
						$institutionDetails =$appLearningIns->learningInstitution->institution_name;
                        }						
                    }
					return $institutionDetails;
					//return implode("\n", $edudetails);
                },
				'filter'=>'',
            ],
            /*
            ['class' => 'yii\grid\ActionColumn',
			'template'=>'{view}',
			],
			*/
			
			[
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Actions',
          'headerOptions' => ['style' => 'color:#337ab7'],
          'template' => '{view}',
          'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view-loanee-details'),
                ]);
            },
          ],
          'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/loan-beneficiary/view-loanee-details-refund&id='.$model->applicant_id;
                return $url;
            }
          }
          ],
			
			
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
