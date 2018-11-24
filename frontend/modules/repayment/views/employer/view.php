<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\EmployerContactPerson;

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
        ],
    ]) ?>
	<div class="text-right">
	<p>
         <?= Html::a('Create New Contact Person', ['add-contact-person', 'employer_id' => $model->employer_id], ['class' => 'btn btn-success']) ?>   
        <?= Html::a('Update Information', ['update-information', 'id' => $model->employer_id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employed-beneficiary/index-view-beneficiary'], ['class' => 'btn btn-warning'])?>
		
    </p>
	</div>
</div>
            <div class="col-md-6">
                <?php  $modelEmployerContactPerson = EmployerContactPerson::find()->where("employer_id = {$model->employer_id} ")->all(); 
                
                
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
                        'label'=>'Email Address',
                        'value'=>$model->user->email_address,
                        //'labelColOptions'=>['style'=>'width:20%'],
                        //'valueColOptions'=>['style'=>'width:30%'],
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
        <?= Html::a('Update/Edit', ['update-information', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>  
		<?= Html::a('Change Password', ['update-password', 'id' => $model->user_id], ['class' => 'btn btn-success']) ?>		
	<?php	
    echo "</p></div>";
    }?>          
	</div> 
        </div>
        <div class="panel-heading">
            <center>
        <?php echo '<p>';
    ?>
        <?= Html::a('View Beneficiary', ['employed-beneficiary/index-view-beneficiary'], ['class' => 'btn btn-success']) ?>  
        <?= Html::a('View Bill', ['loan-repayment/index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('View Payment', ['loan-repayment-detail/bills-payments'], ['class' => 'btn btn-warning']) ?>		
	<?php	
    echo "</p>"; ?>
            </center>
        </div>
            </div>        
    </div>
</div>
