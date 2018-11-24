<?php

use yii\helpers\Html;
 
use kartik\detail\DetailView;
 

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
$this->title = 'Specify Intended Level of Study';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class="guardian-view">
          <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
<?php
            if ($model->loanee_category==""||$model->applicant_category_id==""){
  echo $this->render('study_update', [
        'model' => $model,
       
    ]);
            }
            else{
 $sn = 0;
   
     ++$sn;   
 
        $attributes = [
           
            [
            'group' => true,
            'label' => "Intended Level of Study :  &nbsp;&nbsp; &nbsp;&nbsp; ".Html::a('EDIT', ['/application/application/study-update', 'id' =>$model->application_id],['class' => 'btn btn-primary']),
            'rowOptions' => ['class' => 'info'],
            'format' => 'raw',
        ],
            
            [
                'columns' => [
                  [
                        'label' => 'Applicant Category',
                        'value' => $model->loanee_category,
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                 
                ],
               ],
            
            
                           [
                'columns' => [
                    [
                        'label' => 'Study Level',
                        'value' => $model->applicant_category_id!=""?$model->applicantCategory->applicant_category:"",
                        'labelColOptions'=>['style'=>'width:10%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                 
                ],
               ],
                
            
           
            
        ];
    

    echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);
            }
    ?>
   <div class="text-right1">
  <?= Html::a('<< Go Previous Step', ['applicant/pay-application-fee'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Go Next Step>>', ['default/my-profile'], ['class' => 'pull-right']) ?>
 
            </div>
</div>
          </div>
</div>