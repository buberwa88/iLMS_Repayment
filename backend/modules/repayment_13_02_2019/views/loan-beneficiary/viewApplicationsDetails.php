<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use backend\modules\repayment\models\LoanSummaryDetail;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

//$this->title = "Application Details";
//$this->params['breadcrumbs'][] = ['label' => 'All Loanees', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?php 
	$models = frontend\modules\application\models\Applicant::find()->where(['applicant_id'=>$applicant_id])->all();
	$sn=0;
    foreach ($models as $model) {
     ++$sn;   
        $attributes = [
            [
                'group' => true,
                'label' => 'DEMOGRAPHICS',
                'rowOptions' => ['class' => 'info'],
                'format'=>'raw',
            ],
            [
                'columns' => [

                    [
                        'label' => 'Birth Date',
                        'value' => $model->date_of_birth,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [   
					    'label' => 'Physical Address',
                        'value' => '',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                    
                ],
            ],
            
			[
                'columns' => [

                    [
                        'label' => 'Region of residence',
                        'value' => $model->placeOfBirth->district->region->region_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [   
					    'label' => 'District of residence',
                        'value' => $model->placeOfBirth->district->district_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                    
                ],
            ],
			
			[
                'columns' => [

                    [
                        'label' => 'Ward of residence',
                        'value' => $model->placeOfBirth->ward_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'label' => 'Telephone No.',
						'value' => $model->user->phone_number,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    
                ],
            ],
            
            [
                'columns' => [
                    [
                        'label' => 'Email Address',
						'value' => $model->user->email_address,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
					[
                        'label' => 'Postal Address',
						'value' => '',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                ],
            ], 

        [
                'group' => true,
                'label' => 'PERMANENT ADDRESS',
                'rowOptions' => ['class' => 'info'],
                'format'=>'raw',
            ],
        [
                'columns' => [
				
				    [
                        'label' => 'Postal Address',
                        'value' => '',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],

                    [
                        'label' => 'Region',
                        'value' => $model->placeOfBirth->district->region->region_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],                    
                    
                ],
            ],
			
			[
                'columns' => [
				    [   
					    'label' => 'District',
                        'value' => $model->placeOfBirth->district->district_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],

                    [
                        'label' => 'Ward',
                        'value' => $model->placeOfBirth->ward_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    
                ],
            ], 
            [
                'columns' => [
                    [
                        'label' => 'Village/Street',
						'value' => '',
                        'labelColOptions'=>['style'=>'width:20%'],
                        //'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    
                ],
            ],   			
        ];

    echo DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);
    }
	?>

</div>
    </div>
</div>
