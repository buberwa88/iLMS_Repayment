<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use frontend\modules\application\models\Education;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
$applicant_category=$modelApplication->applicant_category_id>0?$modelApplication->applicantCategory->applicant_category:"";

$this->title = 'Primary Education';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;

?>
 
<div class="guardian-view">
  <div class="panel panel-info">
        <div class="panel-heading">
       Step 4 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$modelApplication->loanee_category."  ".$applicant_category;?></label>
        </div>
       
 
        <div class="panel-body">
     
 <?php
 
 if(Education::find()->where("application_id = {$modelApplication->application_id} AND level = 'PRIMARY' ")->count() == 0){
    //$modelNew=new Education();
     echo $this->render('primary_create', [
                    'model' => $modelNew,
                ]);
}
 
 $models = \frontend\modules\application\models\Education::find()->where("application_id = {$modelApplication->application_id} AND level = 'PRIMARY' ")->all();
 $sn = 0;
    foreach ($models as $model) {
     ++$sn;   
 
        $attributes = [
           
               [
                            'group' => true,
                            'label' => "PRIMARY EDUCATION " . $sn . ':  <div class="pull-right">' . Html::a('EDIT', ['/application/education/primary-update', 'id' => $model->education_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->education_id,'url'=>"primary-view"], [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                    'method' => 'post',
                                                ],
                                            ])."</div>",
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
            [
                'columns' => [

                    [
                        'label' => 'Primary School Name',
                        'value' => $model->institution_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        //'valueColOptions'=>['style'=>'width:30%'],
                    ],
                   
                    
                ],
            ],
            
            
            [
                'columns' => [
                  [
                        'label' => 'Entry Year',
                        'value' => $model->entry_year,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    
                     [
                        'label' => 'Completion Year',
                        'value' => $model->completion_year,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
            ],
           [
               'columns' => [
                  [
                        'label' => 'Region',
                        'value' => $model->learning_institution_id>0?$model->learningInstitution->ward->district->region->region_name:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'District',
                        'value' => $model->learning_institution_id>0?$model->learningInstitution->ward->district->district_name:"", 
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                 
                ],
                     ],
              [
               'columns' => [
                 
//                    [
//                        'label' => 'District',
//                        'value' => 
//                        'labelColOptions'=>['style'=>'width:20%'],
//                        'valueColOptions'=>['style'=>'width:30%'],
//                    ],
                   [
                        'label' => 'Ward',
                        'value' =>  $model->learning_institution_id>0?$model->learningInstitution->ward->ward_name:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:80%'],
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
      echo $this->render('_sponsored_view_details', [
                    'model' => $model,
                ]);
    }
    ?>
          
        <div class="col-lg-12">
  <?= Html::a('<< Previous Step', ['default/my-profile'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Next Step>>', ['education/olevel-view'], ['class' => 'pull-right']) ?>
 
            </div>
</div>
  </div>
</div>