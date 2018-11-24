<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use frontend\modules\application\models\ApplicantAssociate;
//SELECT * FROM `applicant_question` aq join question qu on aq.`question_id`=qu.`question_id` join section_question sq on sq.`question_id`=qu.`question_id` WHERE 1
/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
$this->title = 'Parent Details';
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
 //echo $modelApplication->application_id;
 $parent_count=ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND guarantor_type is NULL limit 2")->count();
 if($parent_count<2){
//    echo '<p class="alert alert-info">';
//    echo '</p>'; 
     $parentdata=  \frontend\modules\application\models\ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND guarantor_type is NULL")->one();
    // print_r($parentdata);
    echo $this->render('create_parent', [
        'model' => $modelNew,
        'parentdata'=> $parentdata,
        'parent_count'=>$parent_count,
    ]);
 //echo Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['parent-create'], ['class' => 'btn btn-success','style'=>'margin-top: -10px; margin-bottom: 5px']);  
}
$models =ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND guarantor_type is NULL limit 20")->all();
 $sn = 0;
    foreach ($models as $model) {
     ++$sn;   
          $sex=$model->sex;
               if($sex=="M"){
               $position="FATHER  Details "  ;       
               }
               else{
               $position="MOTHER  Details "  ;  
               }
        $attributes = [
                [
                            'group' => true,
                            'label' => "  $position " . $sn . ':   &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;' . Html::a('EDIT', ['/application/applicant-associate/parent-update', 'id' => $model->applicant_associate_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->applicant_associate_id,'url'=>'parent-view'], [
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
                        'value' =>  $model->ward_id>0?$model->ward->ward_name:"",
                        'labelColOptions'=>['style'=>'width:15%'],
                        'valueColOptions'=>['style'=>'width:40%'],
                    ],
                ],
                     ],
          
        ];
//          'ward.district.region.region_name',
//            'ward.district.district_name',
//            'ward.ward_name',
    $attributes1 = [
                      [
                            'group' => true,
                            'label' => "  $position " . $sn . ':  &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; ' . Html::a('EDIT', ['/application/applicant-associate/parent-update', 'id' => $model->applicant_associate_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->applicant_associate_id,'url'=>'parent-view'], [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                                    'method' => 'post',
                                                ],
                                            ]),
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
         ];
 
  if($model->is_parent_alive=="YES"){
    echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);
    }
    else{
     echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes1,
    ]);     
    }
 echo $this->render('_view_parent_details', [
        'model' => $model,
    ]);
 echo "<hr/>";
    }
   ?>  
  <div class="col-lg-12">
  <?= Html::a('<< Go Previous Step', ['education/alevel-view'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Go Next Step>>', ['applicant-associate/guardian-view'], ['class' => 'pull-right']) ?>
 
            </div>           
</div>
  </div>
</div>