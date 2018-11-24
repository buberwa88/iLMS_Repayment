<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = "Employer: ".$model->employer_name;
$this->params['breadcrumbs'][] = ['label' => 'New Employers', 'url' => ['new-employer']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-view">
    <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php 
			$results1=$model->getTotalEmployees($model->employer_id);
			if($model->verification_status !=1 && $model->verification_status !=3){ ?>
            <p>
        <?= Html::a('Accept', ['employer-verification-status','employerID'=>$model->employer_id,'actionID'=>'1'], ['class' => 'btn btn-success']) ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a('Cancel', ['employer-verification-status','employerID'=>$model->employer_id,'actionID'=>'0'], ['class' => 'btn btn-warning']) ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a('Reject', ['employer-verification-status', 'employerID' => $model->employer_id,'actionID'=>'3'], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to reject this employer?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
            <?php } ?>
    <?php if($model->verification_status ==1 && $results1 >0){ ?>
            <p>
        <?= Html::a('Employees', ['employed-beneficiary/beneficiaries','employerID'=>$model->employer_id], ['class' => 'btn btn-success']) ?>
                
    </p>
            <?php } ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'employer_id',
            //'user_id',
            'employer_name',
            'employer_code',
            //'employer_type_id',
			[
                     'attribute' => 'employer_type_id',
                        'vAlign' => 'middle',                         
                        'width' => '200px',
                        'value' =>$model->employerType->employer_type,                        
                    ],
            'short_name',
            //'nature_of_work_id',
			[
                     'attribute' => 'nature_of_work_id',
                        'vAlign' => 'middle',                         
                        'width' => '200px',
                        'value' =>$model->natureOfWork->description,                        
                    ],
            'postal_address',
            'physical_address',
           // 'phone_number',
            [
                'attribute'=>'user_id',
                'label'=>'Telephone No',
                'value'=>$model->user->phone_number,
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
                'attribute'=>'ward_id',
                'label'=>'ward',
                'value'=>$model->ward->ward_name,
            ],
            'physical_address',
            [
                'attribute'=>'user_id',
                'label'=>'Contact Person',
                'value'=>$model->user->firstname.", ".$model->user->middlename." ".$model->user->surname,
            ],
            'email_address:email',
            [
            'label'  => 'Status',
            'value'  => call_user_func(function ($data) {
			if($data->verification_status==0){
			return 'Pending Verification';
			}else if($data->verification_status==1){
			return 'Verified';
			}else if($data->verification_status==3){
			return 'Rejected';
			}else{
			return '';
			}
            }, $model),            
        ],
           
        ],
    ]) ?>

</div>
    </div>
</div>
