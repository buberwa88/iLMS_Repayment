<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Loanee Details";
?>
<div class="fixedassets-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
           
<?php
$batchdetails= $this->render('viewapplicant', [
                                'model' => $model,
                               
                            ]);
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Allocation Batch Details',
            'content' =>$batchdetails,
            'id' => '1',
        ],
        [
            'label' => 'Allocation History',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/disbursement/default/myallocatation', 'id' =>$model->applicant_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
       [
            'label' => 'Disbursement History',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/disbursement/disbursement/mydisbursement', 'id' =>$model->applicant_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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