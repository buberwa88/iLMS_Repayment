<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use frontend\modules\application\models\ApplicantAssociate;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
$this->title = "Guardian's Details";
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;
$applicant_category=$modelApplication->applicant_category_id>0?$modelApplication->applicantCategory->applicant_category:"";

?>
 
<div class="guardian-view">
  <div class="panel panel-info">
        <div class="panel-heading">
      Step 8 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$modelApplication->loanee_category." ".$applicant_category;?></label>
        </div>
        <div class="panel-body">
      
 <?php
 
 if(ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GD'")->count()==0){
//    echo '<p class="alert alert-info">';
//    echo   'Click the botton below to add your Guardian details';  
//    echo '</p>'; 
     echo $this->render('create_guardian', [
        'model' => $modelNew,
        'application_id' =>$modelApplication->application_id,
    ]);
 //echo Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['guardian-create'], ['class' => 'btn btn-success','style'=>'margin-top: -10px; margin-bottom: 5px']);  
}
$models =ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GD'")->all();
     $sn = 0;
    foreach ($models as $model) {
               ++$sn;  
             if($model->having_guardian=="YES1"){
            $attributes= [
             [
                            'group' => true,
                            'label' => " Guardian's Details " . $sn . ': <div class="pull-right">' . Html::a('EDIT', ['/application/applicant-associate/guardian-update', 'id' => $model->applicant_associate_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->applicant_associate_id,'url'=>'guardian-view'], [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                    'method' => 'post',
                                                ],
                                            ])."</div>",
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
                ];
                echo '<p class="alert alert-info">';
                echo   'Is your Guardian the same us your Parent  ? :'.$model->having_guardian;  
                echo '</p>';
             }
            else{
          $attributes = [
           
               [
                            'group' => true,
                            'label' => " Guardian's Details " . $sn . ': <div class="pull-right">' . Html::a('EDIT', ['/application/applicant-associate/guardian-update', 'id' => $model->applicant_associate_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->applicant_associate_id,'url'=>'guardian-view'], [
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
                        'label' => 'First Name',
                        'value' => $model->firstname,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                      [
                        'label' => 'Middle Name',
                        'value' => $model->middlename,
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                    
                ],
            ],
            [
                'columns' => [
                 
                     [
                        'label' => 'Surname',
                        'value' => $model->surname,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                   [
                        'label' => 'Sex',
                        'value' => $model->sex,
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                ],
                ],
                [
                 'columns' => [
                 
                     [
                        'label' => 'Occupation',
                        'value' => $model->occupation_id>0?$model->occupation->occupation_desc:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                   [
                        'label' => 'Phone Number',
                        'value' => $model->phone_number,
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                ],  
                ],
                [
                'columns' => [
                    [
                        'label' => 'Postal Address',
                        'value' => $model->postal_address,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'Physical Address',
                        'value' => $model->physical_address,
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                  
                ],
                    ],
                 [
               'columns' => [
                  [
                        'label' => 'Email Address',
                        'value' => $model->email_address,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'Region',
                        'value' => $model->ward_id>0?$model->ward->district->region->region_name:"",
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                 
                ],
                     ],
              [
               'columns' => [
                 
                    [
                        'label' => 'District',
                        'value' =>  $model->ward_id>0?$model->ward->district->district_name:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                   [
                        'label' => 'Ward',
                        'value' => $model->ward_id>0?$model->ward->ward_name:"",
                        'labelColOptions'=>['style'=>'width:15%'],
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
    }
    ?>
  <div class="col-lg-12">
  <?= Html::a('<< Previous Step', ['applicant-associate/parent-view'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Next Step>>', ['applicant-associate/guarantor-view'], ['class' => 'pull-right']) ?>
 
            </div> 
</div>
  </div>
</div>