<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Admission Details";
 
?>
<div class="fixedassets-view">
<div class="box box-info">
            <div class="box-header with-border">
               <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
           
<?php
$details= $this->render('view', [
                                'model' => $model,
                               
                            ]);
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Admission Details',
            'content' =>$details,
            'id' => '1',
        ],
        [
            'label' => 'List of Admitted Student',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/admitted-student/indexall', 'id' =>$model->admission_batch_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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