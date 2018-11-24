<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Double Employed';
$this->params['breadcrumbs'][] = ['label' => 'New Beneficiaries', 'url' => ['new-employed-beneficiaries-found']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],		
            [
                     'attribute' => 'employerName',
                        'label'=>"Employer",
                        'value' => function ($model) {
                            return $model->employer->employer_name;
                        },
            ],
			[
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
			
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
			
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ], 
            [
                     'attribute' => 'sex',
                        'label'=>"Gender",
                        'value' => function ($model) {
                            return $model->applicant->sex;
                        },
            ],
			
            [
                     'attribute' => 'f4indexno',
                        'label'=>"Index Number",
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
            ],
            [
                     'attribute' => 'phone_number',
                        'label'=>"Phone Number",
                        'value' => function ($model) {
                            return $model->phone_number;
                        },
            ],
            [
                     'attribute' => 'employment_status',
                        'label'=>"Status",
                        'value' => function ($model) {
                            return $model->employment_status;
                        },
            ],                    
                ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template'=>'{update}',
                'buttons' => [
            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                ]);
            },
          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'update') {
                $url ='index.php?r=repayment/employed-beneficiary/deactivate-double-employed&id='.$model->employed_beneficiary_id;
                return $url;
            }
          }            
            ],
        ],
    ]); ?>
</div>
       </div>
</div>
