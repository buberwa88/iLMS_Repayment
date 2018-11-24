<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'My Account';
$this->params['breadcrumbs'][] = ['label' => 'My Account', 'url' => ['view','id'=>$model->employer_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-view">
    <div class="panel panel-info">
        <div class="panel-body">
    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => [
            //'employer_id',
            //'user_id',
			[
                'group' => true,
                'label' => "Employer Details",
                'rowOptions' => ['class' => 'info']
            ],
            'employer_name',
            'short_name',
			'TIN',
            [
                     'attribute' => 'employer_type_id',
                        'value' =>$model->employerType->employer_type,                        
                    ],
			[
                     'attribute' => 'nature_of_work_id',
					 'label'=>'Sector',
                        'value' =>$model->natureOfWork->description,                        
                    ],
            'postal_address',
            'physical_address',		
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
			[
                'attribute'=>'phone_number',
				'label'=>'Telephone Number',
                'value'=>$model->phone_number,
            ],
            'fax_number',
            [
                'attribute'=>'email_address',
                'label'=>'Office Email Address',
                'value'=>$model->email_address,
            ],			 
					

			
			[
                'group' => true,
                'label' => "Contact Person Details",
                'rowOptions' => ['class' => 'info']
            ],
            [
                'attribute'=>'user_id',
                'label'=>'Name',
                'value'=>$model->user->firstname.", ".$model->user->middlename." ".$model->user->surname,
            ],
			[
                'attribute'=>'phone_number',
				'label'=>'Telephone Number',
                'value'=>$model->user->phone_number,
            ],
			[
                'attribute'=>'email_address',
                'label'=>'Email Address',
                'value'=>$model->user->email_address,
            ],          
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
	<div class="text-right">
	<p>
        <?= Html::a('Update Information', ['update-information', 'id' => $model->employer_id], ['class' => 'btn btn-primary']) ?>  
		<?= Html::a('Change Password', ['update-password', 'id' => $model->employer_id], ['class' => 'btn btn-success']) ?>
		<?= Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employed-beneficiary'], ['class' => 'btn btn-warning'])?>
		
    </p>
	</div>
</div>
    </div>
</div>
