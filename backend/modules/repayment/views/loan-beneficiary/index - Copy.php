<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pending Registered Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-repayment-index">

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

            //'loan_beneficiary_id',
			[
                'attribute' => 'firstname',
                'label' => "First Name",
                'width' => '200px',
                'value' => function ($model) {
                    return $model->firstname;
                },
            ],
			[
                'attribute' => 'middlename',
                'label' => "Middle Name",
                'width' => '200px',
                'value' => function ($model) {
                    return $model->middlename;
                },
            ],
			[
                'attribute' => 'surname',
                'label' => "Last Name",
                'width' => '200px',
                'value' => function ($model) {
                    return $model->surname;
                },
            ],
			[
                'attribute' => 'f4indexno',
                'label' => "Form IV Index No.",
                'width' => '200px',
                'value' => function ($model) {
                    return $model->f4indexno;
                },
            ],
           // 'f4indexno',
		   /*
			[
                'attribute' =>'learning_institution_id',
				'label'=>'Learning Institution',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->learningInstitution->institution_name;
                },
            ],
			*/
			[
                'attribute' =>'applicant_id',
				'label'=>'Status',
                'width' => '200px',
				'format'=>'raw',
                'value' => function ($model) {
				if($model->applicant_id==''){
				return '<p class="btn green"; style="color:red;">Pending Verification</p>';
				}else{
				return '<p class="btn green"; style="color:green;">Confirmed</p>';
				}                    
                },
            ],
            // 'NID',
            // 'date_of_birth',
            // 'place_of_birth',
            // 'learning_institution_id',
            // 'postal_address',
            // 'physical_address',
            // 'phone_number',
            // 'email_address:email',
            // 'password',

            //['class' => 'yii\grid\ActionColumn'],
			
			[
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Actions',
          'headerOptions' => ['style' => 'color:#337ab7'],
          'template' => '{view}{update}',
          'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                ]);
            },

            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('app', 'delete'),
                ]);
            }

          ],
          'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/loan-beneficiary/view&id='.$model->loan_beneficiary_id;
                return $url;
            }

            if ($action === 'update') {
                $url ='index.php?r=repayment/loan-beneficiary/update&id='.$model->loan_beneficiary_id;
                return $url;
            }
            if ($action === 'delete') {
                $url ='index.php?r=repayment/loan-beneficiary/delete&id='.$model->loan_beneficiary_id;
                return $url;
            }

          }
          ],
			
			
        ],
		'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode('Pending Registered Beneficiaries') . ' </h3>',
            'type' => 'info',
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['all-beneficiaries'], ['class' => 'btn btn-info']),
            'showFooter' => true
        ],
    ]); ?>
</div>
    </div>
</div> 
