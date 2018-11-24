<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'My Account';
$this->params['breadcrumbs'][] = ['label' => 'My Account', 'url' => ['view','id'=>$model->employer_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-view">
    <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'employer_id',
            //'user_id',
            'employer_name',
			'short_name',
			'employer_code',
			'TIN',
            [
                     'attribute' => 'employer_type_id',
                        'vAlign' => 'middle',                         
                        'width' => '200px',
                        'value' =>$model->employerType->employer_type,                        
                    ],
            
           // 'nature_of_work_id',
			[
                     'attribute' => 'nature_of_work_id',
                        'vAlign' => 'middle',                         
                        'width' => '200px',
                        'value' =>$model->natureOfWork->description,                        
                    ],
            'postal_address',
            'physical_address',
            //'phone_number',
            [
                'attribute'=>'user_id',
                'label'=>'Mobile Telephone No.',
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
            'phone_number',
			'fax_number',
			'email_address:email',
            [
                'attribute'=>'user_id',
                'label'=>'Contact Person',
                'value'=>$model->user->firstname.", ".$model->user->middlename." ".$model->user->surname,
            ],
			[
                'attribute'=>'user_id',
                'label'=>'Contact Person Telephone No.',
                'value'=>$model->user->phone_number,
            ],
			[
                'attribute'=>'user_id',
                'label'=>'Contact Person Email Address',
                'value'=>$model->user->email_address,
            ],
            
            [
                'attribute'=>'verification_status',
                'label'=>'Account Status',
                'value'=>$model->verification_status==1 ? "Verified" : "Not Verified",
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
