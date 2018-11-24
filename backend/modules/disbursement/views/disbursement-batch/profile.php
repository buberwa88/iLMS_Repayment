<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Batch Details";
 
?>
<div class="fixedassets-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
           
<?php
$batchdetails= $this->render('view', [
                                'model' => $model,
                               
                            ]);
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Batch Details',
            'content' =>$batchdetails,
            'id' => '1',
        ],
        [
            'label' => 'Disbursed Details',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/disbursement/disbursement/disbursed', 'id' =>$model->disbursement_batch_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ], 
        [
            'label' => 'Payout List Movement',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/disbursement/payoutlist-movement/list-movement', 'id' =>$model->disbursement_batch_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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