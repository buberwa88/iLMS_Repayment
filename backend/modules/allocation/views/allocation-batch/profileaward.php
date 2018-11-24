<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Award Loan ";
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alloca'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
           
<?php
$details= $this->render('viewaward', [
                                'model' => $model,
                               
                            ]);
echo TabsX::widget([
    'items' => [
        [
            'label' => 'List of Awarded Student (s)',
            'content' =>$details,
            'id' => '1',
        ],
        [
            'label' => 'List of Allocated Student(s)',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/allocation/index', 'id' =>1]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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