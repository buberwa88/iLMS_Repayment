<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Criteria Details";
 
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
            'label' => 'Criteria Details',
            'content' =>$details,
            'id' => '1',
        ],
//        [
//            'label' => 'Criteria Question Details ',
//            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/criteria-question/index', 'id' =>$model->criteria_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
//            'id' => '2',
//        ], 
        [
            'label' => 'Criteria Configuration',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/criteria-field', 'id' =>$model->criteria_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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