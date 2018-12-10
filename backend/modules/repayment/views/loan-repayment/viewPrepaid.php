<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Pre-payment";
?>
<div class="employed-beneficiary-view">
<div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
           
<?php						
echo TabsX::widget([
    'items' => [
        
		[
            'label' => 'Bill Details',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment/prepaidbillview', 'employer_id' =>$employer_id,'bill_number' =>$bill_number]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '1',
        ],
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-repayment/prepaidbeneficiariesview', 'employer_id' =>$employer_id,'bill_number' =>$bill_number]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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