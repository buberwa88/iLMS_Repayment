<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = "Un-verified employees";
$this->params['breadcrumbs'][] = ['label' => 'Un-verified employees', 'url' => ['un-verified-uploaded-employees']];
$this->params['breadcrumbs'][] = $this->title;
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
            //'employed_beneficiary_id',
            //'employer_id',
			/*
            [
                'attribute'=>'employer_id',
                'label'=>'Employer Name',
                'value'=>$model->employer->employer_name,
            ],
			*/            
            //'applicant_id',
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
                'attribute'=>'place_of_birth',
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
        <?= Html::a('Update', ['update', 'id' => $model->employed_beneficiary_id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employed-beneficiary/un-verified-uploaded-employees'], ['class' => 'btn btn-warning'])?>
    </p>
	</div>
</div>
    </div>
</div>
