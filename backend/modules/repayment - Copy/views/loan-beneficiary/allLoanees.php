<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\application\models\ApplicantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <br/>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute' => 'olevel_index',
				'header'=>'Form IV Indexno',
                                'format' => 'raw',
                'value' => function ($model) {
                 return Html::a($model->f4indexno, ['/repayment/loan-beneficiary/view-loanee-details','id'=>$model->applicant_id]);
                /*
                $educationDetails = array();	
                $num=0;				
				foreach ($model->applications as $appEduDetails) {						
						foreach ($appEduDetails->educations as $appeducation) {
						//$educationDetails[] = $appeducation->application_id;
						$educationDetails =$appeducation->olevel_index;
                        }						
                    }
					return $educationDetails;
                                        */
					//return implode("\n", $edudetails);
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'firstname',
		'header'=>'First Name',
                'format' => 'raw',
                'value' => function ($model) {
                    //return $model->user->firstname;
                    return Html::a($model->user->firstname, ['/repayment/loan-beneficiary/view-loanee-details','id'=>$model->applicant_id]);
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'middlename',
				'header'=>'Middle Name',
                                'format' => 'raw',
                'value' => function ($model) {
                    //return $model->user->middlename;
                    return Html::a($model->user->middlename, ['/repayment/loan-beneficiary/view-loanee-details','id'=>$model->applicant_id]);
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'surname',
				'header'=>'Last Name',
                                'format' => 'raw',
                'value' => function ($model) {
                    //return $model->user->surname;
                    return Html::a($model->user->surname, ['/repayment/loan-beneficiary/view-loanee-details','id'=>$model->applicant_id]);
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
                                'format' => 'raw',
                'value' => function ($model) {
				    if($model->sex=='M'){
					$sex="Male";
					}else if($model->sex=='F'){
					$sex="Female";
					}else{
					$sex="Not set";
					}
				     
                    //return $sex;
                    return Html::a($sex, ['/repayment/loan-beneficiary/view-loanee-details','id'=>$model->applicant_id]);
                },
				'filter'=>'',
            ],

            [
                'attribute' => 'date_of_birth',
				'header'=>'Birth Date',
                                'format' => 'raw',
                'value' => function ($model) {	
                    if($model->date_of_birth=='0000-00-00'){
					$results="Not Set";
					}else{				
                    $results=$model->date_of_birth;
					}
					//return $results;
                                        return Html::a($results, ['/repayment/loan-beneficiary/view-loanee-details','id'=>$model->applicant_id]);
                },
				'filter'=>'',
            ],						
            
                        /*
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

					return $model->applications->disbursements->programme->learningInstitution->institution_name;
					//return implode("\n", $edudetails);
                },
				'filter'=>'',
            ],
            */            
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
                $url ='index.php?r=repayment/loan-beneficiary/view-loanee-details&id='.$model->applicant_id;
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
