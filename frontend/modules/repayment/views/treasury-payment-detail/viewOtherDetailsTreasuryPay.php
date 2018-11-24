<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

//$this->title = "Application Details";
//$this->params['breadcrumbs'][] = ['label' => 'All Loanees', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-body">
    <?php 
	//$models = frontend\modules\application\models\Applicant::find()->where(['applicant_id'=>$applicant_id])->all();
	//$sn=0;
    //foreach ($models as $model) {
     //++$sn;   
        $attributes = [
            [
                'group' => true,
                'label' => 'Other Details',
                'rowOptions' => ['class' => 'info'],
                'format'=>'raw',
            ],
            [
                'columns' => [

                    [
                        'label' => 'Middle Name',
                        'value' => $model->applicant->user->middlename,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [   
		        'label' => 'Employer Bill',
                        'value' => $model->loanRepayment->bill_number,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                    
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
   // }
	?>

</div>
    </div>
</div>
