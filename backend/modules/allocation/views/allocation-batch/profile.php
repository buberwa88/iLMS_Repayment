<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Allocation Batch Details";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batch'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
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
            'label' => 'Allocation Batch',
            'content' =>$details,
            'id' => '1',
        ],
        /*[
            'label' => 'List of Allocated Student(s) Details',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/allocation/index', 'id' =>$model->allocation_batch_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ], */
        [
            'label' => 'List of Allocated Student(s) Summary',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/allocation/batch-allocated-summary', 'id' =>$model->allocation_batch_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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