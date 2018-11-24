<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\Question $model
 */

$this->title = 'Update Question: ';
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-update">
    <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
   <?php 
   
   $items = [
        [
           'label'=>'Question Details',
           'content'=>$this->render('_form', [
                            'model' => $model,
                        ]),
           'id'=>'1',
        ],
       
        
        
    ];
   $item2 = [
           'label'=>'Question Response',
           'content'=>'<iframe src="'.yii\helpers\Url::to(['/application/qpossible-response/index','question_id'=>$model->question_id]).'" width="100%" height="400px" style="border: 0"  id="question-response-frame-id"></iframe>',
           'id'=>'2',
        ];
   if( ($model->response_control == 'DROPDOWN' || $model->response_control == 'CHECKBOX')  && $model->qresponse_source_id == NULL){
       array_push($items, $item2);
   }
   
      $item3 = [
           'label'=>'Categories',
           'content'=>'<iframe src="'.yii\helpers\Url::to(['/application/section-question/index','question_id'=>$model->question_id]).'" width="100%" height="400px" style="border: 0"  id="question-response-frame-id"></iframe>',
           'id'=>'3',
        ];
      
      array_push($items, $item3);
   
    echo TabsX::widget([
    'items' => $items,
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
    

 yii\jui\Dialog::begin([
                'id' => 'questions-dialog-id',
                'clientOptions' => [
                    'width' => '500',
                    'height' => '400',
                    'modal' => true,
                    'autoOpen' => false,
                ]
            ]);

            echo '<iframe src="" id="questions-iframe-id" width="100%" height="100%" style="border: 0">';
            echo '</iframe>';
            echo '<br><br>';
            yii\jui\Dialog::end();    

?>

</div>
    </div>
</div>
