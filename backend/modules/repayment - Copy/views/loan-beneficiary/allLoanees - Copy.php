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
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <br/>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'attribute' => 'olevel_index',
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
                'value' => function ($model) {
                    return $model->user->firstname;
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'middlename',
                'value' => function ($model) {
                    return $model->user->middlename;
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'surname',
                'value' => function ($model) {
                    return $model->user->surname;
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'NID',
                'value' => function ($model) {
                    return $model->NID;
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'applicationID',
                'value' => function ($model) {	
                $applicant_details = array();			
				foreach ($model->applications as $appFDetails) {
				        
						
                        $applicant_details = $appFDetails->application_id;
						// here if i want them in array
						//$applicant_details[] = $appFDetails->applicant_id;
                        // end if i want them in array						
                    }
                    return $applicant_details;
					//here if array
					//return implode("\n", $applicant_details);
					//end if array
                },
				'filter'=>'',
            ],
			[
                'attribute' => 'olevel_index',
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
            // 'mailing_address',
            // 'date_of_birth',
            // 'place_of_birth',
            // 'loan_repayment_bill_requested',

            ['class' => 'yii\grid\ActionColumn'],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
