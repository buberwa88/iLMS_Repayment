<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Employer";
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
   <p>
    <?php echo Html::a('Add New Employee', ['create'], ['class' => 'btn btn-info']) ?>             
    <?= Html::a('Upload New Employees', ['index-upload-employees'], ['class' => 'btn btn-warning']) ?> 
	</p>        
<?php
$employerDetails= $this->render('viewEmployerDetails', [
                                'model' => $model,
								'id' => $id,
                               
                            ]);
//$employees= $this->render('/employed-beneficiary/beneficiariesUnderEmployer', [                                
                                //'searchModel' => $searchModelEmployedBeneficiaries,
								//'dataProvider' => $dataProvider,
								//'employerID'=>$id,								
                            //]);								
							
echo TabsX::widget([
    'items' => [
        
		[
            'label' => 'Employer Details',
            'content' =>$employerDetails,
            'id' => '1',
        ],
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/beneficiaries-under-employer', 'employerID' =>$model->employer_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],		
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>
</div>
    </div>
</div>  