<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = "Loan Beneficiary";
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">    

    <?= DetailView::widget([
        'model' => $model,
		'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => [
            [
                'attribute'=>'firstname',
                'value'=>$model->firstname,
            ],
			[
                'attribute'=>'middlename',
                'value'=>$model->middlename,
            ],
			[
                'attribute'=>'surname',
                'value'=>$model->surname,
            ],
			[
                'attribute'=>'sex',
                'value'  =>call_user_func(function ($data) {
				 if($data->sex=="M"){
				return "Male"; 
				 }else if($data->sex=="M"){
				return "Female"; 
				 }				
            }, $model),
            ],
			[
                'attribute'=>'date_of_birth',
                'value'=>$model->date_of_birth,				
            ],
			[
                'attribute'=>'region',
                'label'=>'Region',
                'value'=>$model->ward->district->region->region_name,
            ],
            [
                'attribute'=>'district',
                'label'=>'District',
                'value'=>$model->ward->district->district_name,
            ],
            [
                'attribute'=>'place_of_birth',
                'label'=>'ward',
                'value'=>$model->ward->ward_name,
            ],
			[
                'attribute'=>'phone_number',
                'value'=>$model->phone_number,				
            ],
			[
                'attribute'=>'f4indexno',
                'value'=>$model->f4indexno,				
            ],
			[
                'attribute'=>'learning_institution_id',
                'value'=>$model->learningInstitution->institution_name,
            ],
			[
                'attribute'=>'NID',
                'value'=>$model->NID,				
            ],
            [
                'attribute'=>'employee_id',
                'value'=>$model->employee_id,
            ],  
            [
                'attribute'=>'basic_salary',
                'value'  =>$model->basic_salary,
				'format' => ['decimal', 2],
            ],			
            'employment_status',            
        ],
    ]) ?>
	<div class="text-right">
    <p>
        <?= Html::a('Update', ['update-beneficiary', 'id' => $model->employed_beneficiary_id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['beneficiaries-verified'], ['class' => 'btn btn-warning'])?>
    </p>
	</div>
</div>
    </div>
</div>
