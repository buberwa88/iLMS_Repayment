<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Disbursement Schedules";
 
?>
<div class="disbursement-schedule-view">
    <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
           
<?php
$details= $this->render('view', [
                                'model' => $model,
                               
                            ]);
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Disbursement Schedule',
            'content' =>$details,
            'id' => '1',
        ],
        [
            'label' => 'Task Assigned To',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/disbursement/disbursement-task-assignment/index', 'id' =>$model->disbursement_schedule_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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