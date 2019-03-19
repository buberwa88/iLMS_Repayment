<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */

$this->title = "List of successful uploaded employees";
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
			/*
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
			*/
            [
                'attribute'=>'uploaded_sex',
                'label'=>'Sex',
                'visible'=>$model->uploaded_sex !='',
                'value'=>$model->uploaded_sex,
            ],
            [
                'attribute'=>'sex',
                'label'=>'Sex',
                'visible'=>$model->uploaded_sex =='',
                'value'  =>call_user_func(function ($data) {
                    if($data->sex=="M"){
                        return "Male";
                    }else if($data->sex=="M"){
                        return "Female";
                    }
                }, $model),
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
                'attribute'=>'form_four_completion_year',
                'label'=>'Form IV Completion Year',
                'value'=>$model->form_four_completion_year,
            ],
			[
                'attribute'=>'uploaded_level_of_study',
                'label'=>'Study Level',
                'visible'=>$model->uploaded_level_of_study =='',
                'value'=>$model->programmeStudyLevel->applicant_category,
            ],
            [
                'attribute'=>'uploaded_level_of_study',
                'label'=>'Study Level',
                'visible'=>$model->uploaded_level_of_study !='',
                'value'=>$model->uploaded_level_of_study,
            ],
            [
                'attribute'=>'uploaded_learning_institution_code',
                'label'=>'Learning Institution',
                'visible'=>$model->uploaded_learning_institution_code !='',
                'value'=>$model->uploaded_learning_institution_code,
            ],
            [
                'attribute'=>'learning_institution_id',
                'label'=>'Learning Institution',
                'visible'=>$model->learning_institution_id !='',
                'value'=>$model->learningInstitution->institution_name,
            ],
            [
                'attribute' => 'programme',
                'label' => "Programme Studied",
                'visible'=>$model->uploaded_programme_studied =='',
                'value'=>$model->programmeName->programme_name,
            ],
            [
                'attribute' => 'uploaded_programme_studied',
                'label' => "Programme Studied",
                'visible'=>$model->uploaded_programme_studied !='',
                'value'=>$model->uploaded_programme_studied,
            ],
            [
                'attribute' => 'programme_entry_year',
                'label' => "Entry Year",
                'value'=>$model->programme_entry_year,
            ],
            [
                'attribute' => 'programme_completion_year',
                'label' => "Completion Year",
                'value'=>$model->programme_completion_year,
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
            [
                'attribute'=>'salary_source',
                'value'  =>call_user_func(function ($data) {
                    if($data->salary_source==2){
                        return "Own Source";
                    }else if($data->salary_source==1){
                        return "Central Government";
                    }
                }, $model),
            ],
            'employment_status',            
        ],
    ]) ?>
	<div class="text-right">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->employed_beneficiary_id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", [$action], ['class' => 'btn btn-warning'])?>
    </p>
	</div>
</div>
    </div>
</div>
