<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title = "Loan Summary No: ".$model->reference_number;
$this->params['breadcrumbs'][] = ['label' => 'Loan Summary', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
<div class="box box-info">
            <div class="box-header with-border">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
           
<?php								
							
echo TabsX::widget([
    'items' => [  
         [
            'label' => 'Loan Summary',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-summary/view-loan-summary-approved','id'=>$model->loan_summary_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],	
        [
            'label' => 'Beneficiaries',
            'content' => '<iframe src="' . yii\helpers\Url::to(['loan-summary/view-loanees-in-loan-summary-approved','id'=>$model->loan_summary_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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