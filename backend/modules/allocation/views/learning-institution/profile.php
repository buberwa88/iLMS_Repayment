<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Learning Institution Details";
 
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
            'label' => 'Learning Institution Details',
            'content' =>$details,
            'id' => '1',
        ],
//        [
//            'label' => 'Criteria Question Details ',
//            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/criteria-question/index', 'id' =>$model->criteria_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
//            'id' => '2',
//        ], 
        [
            'label' => 'Contact Personal',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/learning-institution-contact', 'id' =>12]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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