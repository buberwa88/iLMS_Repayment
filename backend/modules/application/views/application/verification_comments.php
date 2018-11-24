<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
 


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">         
            <?php //echo Html::encode($this->title) ?> 
            
        </div>
        <div class="panel-body">
      <?php 
	$models = \frontend\modules\application\models\ApplicantAttachment::find()                
                ->where(['application_id'=>$model->application_id])
                ->andWhere(['not',['comment'=>'']])
                ->andWhere(['not',['comment'=>NULL]])->all();
	//$sn=0;
        
//            [
//                'group' => true,
//                'label' => 'Verification Comments',
//                'rowOptions' => ['class' => 'info'],
//                'format'=>'raw',
//            ]
    foreach ($models as $modelApplicantAttachment) {
   
        $attributes = [
            [
                'columns' => [
                    [
                        'label'=>'Comment',
                        'value' => backend\modules\application\models\VerificationComment::getVerificationComment($modelApplicantAttachment->comment),
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:20%'],
                    ],
                    
                    
                ],
            ], 
   			
        ];

    echo DetailView::widget([
        'model' => $modelApplicantAttachment,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,        
    ]);
    }
	?>
     </div>
</div>
</div>
