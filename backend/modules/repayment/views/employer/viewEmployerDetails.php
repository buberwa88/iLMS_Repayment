<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\EmployerContactPerson;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/*
$this->title = 'My Account';
$this->params['breadcrumbs'][] = ['label' => 'My Account', 'url' => ['view','id'=>$model->employer_id]];
$this->params['breadcrumbs'][] = $this->title;
*/
?>
<div class="employer-view">
        <div class="panel-body">
            <div class="col-md-6">
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
                'attribute'=>'salary_source',
                'label'=>'Salary Source',
                'value'=>call_user_func(function ($data) {
			if($data->salary_source==1){
			return 'Central Government';
			}else if($data->salary_source==2){
			return 'Own Source';
			}
            }, $model),
			'visible'=>call_user_func(function ($data) {
			 if($data->salary_source==1 || $data->salary_source==2){
			 return true;
			 }else{
			 return false;
			 }
            }, $model),
            ],
            [
                'columns' => [

                    [
                        'label'=>'Status',
                        'value'=>call_user_func(function ($data) {
                            if($data->verification_status==1){
                                return 'Confirmed';
                            }else if($data->verification_status==2){
                                return 'Waiting Activation';
                            }else if($data->verification_status==3){
                                return 'Deactivated';
                            }else if($data->verification_status==0){
                                return 'Pending Verification';
                            }
                        }, $model),
                    ],
                ],
            ],
            [
                'columns' => [

                    [
                        'label'=>'Reason',
                        'visible'=>$model->verification_status==3,
                        'value'=>$model->rejection_reason,
                    ],
                ],
            ],
        ],
    ]) ?>
	<div class="text-right">
        <?php

        if($model->verification_status !=3 && $model->verification_status !=2){ ?>
	<p>
         <?= Html::a('Create New Contact Person', ['add-contact-person', 'employer_id' => $model->employer_id], ['class' => 'btn btn-success']) ?>   
        <?= Html::a('Update Information', ['update-information', 'id' => $model->employer_id], ['class' => 'btn btn-primary']) ?>
		
    </p>
        <?php } ?>
	</div>
	<div class="text-right">
<?php 

			if($model->verification_status !=1 && $model->verification_status !=3 && $model->verification_status !=2){ ?>
        <?= Html::a('Confirm', ['employer-confirmheslb','employerID'=>$model->employer_id,'actionID'=>'1'], ['class' => 'btn btn-success']) ?>      
            <?php } ?>
<?php

if($model->verification_status !=3){ ?>
			<?= Html::a('Deactivate', ['employer-confirmheslb','employerID' => $model->employer_id,'actionID'=>'3'],[
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to deactivate this employer?',
                'method' => 'post',
            ],
        ]) ?>
<?php } ?>
		<?php 

			if($model->verification_status ==2 || $model->verification_status ==3){ ?>
		<?= Html::a('Activate Acount', ['activate-accountheslb','employerID' => $model->employer_id],[
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to Activate this employer?',
                'method' => 'post',
            ],
        ]) ?>
			<?php } ?>
		<?= Html::a('Cancel', ['employer-verification-status','employerID'=>$model->employer_id,'actionID'=>'0'], ['class' => 'btn btn-warning']) ?>
			</div>
</div>
            <div class="col-md-6">
                <?php  $modelEmployerContactPerson = EmployerContactPerson::find()->where("employer_id = {$model->employer_id}")->all();
                
                
                $sn = 0;
    foreach ($modelEmployerContactPerson as $model) {
     ++$sn;   
      if($sn==1){
        $contact="Primary";  
      }else{
        $contact="Secondary";  
      }
        $attributes = [
            [
                'group' => true,
                'label' => "Contact Person Details(".$contact.")",
                'rowOptions' => ['class' => 'info']
            ],
            [
                'columns' => [

                    [
                        'label' => 'Name',
                        'value'=>$model->user->firstname.", ".$model->user->middlename." ".$model->user->surname,
                        //'labelColOptions'=>['style'=>'width:20%'],
                        //'valueColOptions'=>['style'=>'width:30%'],
                    ],                   
                    
                ],
            ],
            
            [
                'columns' => [

                    [
                        'label'=>'Telephone #',
                        'value'=>$model->user->phone_number,
                        //'labelColOptions'=>['style'=>'width:20%'],
                        //'valueColOptions'=>['style'=>'width:30%'],
                    ]
                ],
            ],
			[
                'columns' => [

                    [
                        'label'=>'Username',
                        'value'=>$model->user->username,
                        //'labelColOptions'=>['style'=>'width:20%'],
                        //'valueColOptions'=>['style'=>'width:30%'],
                    ]
                ],
            ],
            
            [
                'columns' => [

                    [
                        'label'=>'Email Address',
                        'value'=>$model->user->email_address,
                        //'labelColOptions'=>['style'=>'width:20%'],
                        //'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
            ],
            [
                'columns' => [

                    [
                        'label'=>'Status',
                        'value'=>call_user_func(function ($data) {
                            if($data->is_active==1){
                                return 'Active';
                            }else if($data->is_active==2){
                                return 'InActive';
                            }
                        }, $model),
                    ],
                ],
            ],

        ];
    

    echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);
    echo '<div class="text-right">
	<p>';
    ?>
                <?php

                if($model->employer->verification_status !=3){
                    if($model->employer->verification_status !=2){
                    ?>
        <?= Html::a('Update/Edit', ['update-contactperson', 'id' => $model->user_id,'emploID'=>$model->employer_id], ['class' => 'btn btn-primary']) ?>  
		<?= Html::a('Change Password', ['change-password-contactp', 'id' => $model->user_id,'emploID'=>$model->employer_id], ['class' => 'btn btn-success']) ?>
                    <?php }} ?>
	<?php	
    echo "</p></div>";
    }?>          
	</div>       
    </div>
	</div>
