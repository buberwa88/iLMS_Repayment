<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\detail\DetailView;
use frontend\modules\application\models\Education;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
$this->title = 'Post Form IV Education';
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
 
 if(Education::find()->where("application_id = {$modelApplication->application_id} AND level IN('ALEVEL','COLLEGE')")->count() == 0){
  
      echo $this->render('_alevel_form', [
                    'model' => $modelNew,
                ]);
}
else{
 echo Html::a('<i class="glyphicon glyphicon-plus"></i> Click to add  Post Form IV Education Details if you have more than one', ['alevel-create'], ['class' => '','style'=>'margin-top: -10px; margin-bottom: 15px']);   
 echo "<br/>";
 echo "<br/>";
}
 
// echo Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['alevel-create'], ['class' => 'btn btn-success','style'=>'margin-top: -10px; margin-bottom: 5px']);   
 $models = \frontend\modules\application\models\Education::find()->where("application_id = {$modelApplication->application_id} AND level IN('ALEVEL','COLLEGE') ")->all();
 $sn = 0;
    foreach ($models as $model) {
     ++$sn;   
                      if($model->is_necta==1){
                       $label='A-LEVEL SCHOOl';      
                      }
                    else if($model->is_necta==2){
                       $label='NON-NECTA INSTITUTION NAME';    
                    }
                   else{
                     $label="NACTE";     
                   }
    
      if($model->is_necta==1||$model->is_necta==2){      
        $attributes = [
//            [
//                'group' => true,
//                'label' => 'ALEVEL/COLLEGE EDUCATION '.$sn.': ['.Html::a('EDIT', ['/application/education/alevel-update','id'=>$model->education_id]).'] &nbsp;&nbsp; ['.Html::a('REMOVE', '#',['onclick'=>'removeRecord('.$model->education_id.')']).']',
//                'rowOptions' => ['class' => 'info'],
//                'format'=>'raw',
//            ],
               [
                            'group' => true,
                            'label' => " $label " . $sn . ':  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;' . Html::a('EDIT', ['/application/education/alevel-update', 'id' => $model->education_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->education_id,'url'=>"alevel-view"], [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                    'method' => 'post',
                                                ],
                                            ]),
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
            [
                'columns' => [
                      [
                        'label' => 'A-Level Index#',
                        'value' => $model->registration_number,
                        'labelColOptions'=>['style'=>'width:30%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                ],
            ],
             [
                'columns' => [
                    
                    [
                        'label' =>$label,
                        'value' =>$model->learning_institution_id!=""?$model->learningInstitution->institution_name:"",
                        'labelColOptions'=>['style'=>'width:30%'],
                         'valueColOptions'=>['style'=>'width:40%'],
                    ],
                   
                    
                ],
            ],
            [
                'columns' => [
//                  [
//                        'label' => 'Entry Year',
//                        'value' => $model->entry_year,
//                        'labelColOptions'=>['style'=>'width:20%'],
//                        'valueColOptions'=>['style'=>'width:30%'],
//                    ],
                    
                     [
                        'label' => 'Completion Year',
                        'value' => $model->completion_year,
                        'labelColOptions'=>['style'=>'width:30%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                ],
            ],
           
            
        ];
      }
      else{
                
        $attributes = [
//            [
//                'group' => true,
//                'label' => 'ALEVEL/COLLEGE EDUCATION '.$sn.': ['.Html::a('EDIT', ['/application/education/alevel-update','id'=>$model->education_id]).'] &nbsp;&nbsp; ['.Html::a('REMOVE', '#',['onclick'=>'removeRecord('.$model->education_id.')']).']',
//                'rowOptions' => ['class' => 'info'],
//                'format'=>'raw',
//            ],
               [
                            'group' => true,
                            'label' => " NACTE " . $sn . ':  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;' . Html::a('EDIT', ['/application/education/alevel-update', 'id' => $model->education_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->education_id,'url'=>"alevel-view"], [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                    'method' => 'post',
                                                ],
                                            ]),
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
            [
                'columns' => [
                      [
                        'label' => 'Award Verification Number (AVN)',
                        'value' => $model->avn_number,
                        'labelColOptions'=>['style'=>'width:30%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                ],
            ],
              [
                'columns' => [
                      [
                        'label' => 'Programme Name',
                        'value' => $model->programme_name,
                        'labelColOptions'=>['style'=>'width:30%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                ],
            ],
             [
                'columns' => [
                    
                    [
                        'label' =>'Institution Name',
                        'value' =>$model->learning_institution_id!=""?$model->learningInstitution->institution_name:"",
                        'labelColOptions'=>['style'=>'width:30%'],
                         'valueColOptions'=>['style'=>'width:40%'],
                    ],
                   
                    
                ],
            ],
            [
                'columns' => [
//                  [
//                        'label' => 'Entry Year',
//                        'value' => $model->entry_year,
//                        'labelColOptions'=>['style'=>'width:20%'],
//                        'valueColOptions'=>['style'=>'width:30%'],
//                    ],
                    
                     [
                        'label' => 'Completion Year',
                        'value' => $model->completion_year,
                        'labelColOptions'=>['style'=>'width:30%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                ],
            ],
           
            
        ];
    
     
      }

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
  <?= Html::a('<< Go Previous Step', ['education/olevel-view'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Go Next Step>>', ['applicant-associate/parent-view'], ['class' => 'pull-right']) ?>
 
            </div>
</div>
    </div>
</div>