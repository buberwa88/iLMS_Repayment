<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use frontend\modules\application\models\ApplicantAssociate;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guardian $model
 */
$this->title = 'Guarantor Details';
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
            if (ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'GA'")->count() == 0) {
        echo $this->render('create_guarantor', [
                    'model' => $modelNew,
                    'modelApplication'=>$modelApplication,
                ]);
            }
            $models = \frontend\modules\application\models\Guarantor::find()->where("application_id = {$modelApplication->application_id} AND type = 'GA'")->all();
            $sn = 0;
            /*
             * Organization Academic
             */

            /*
             * end
             */
            foreach ($models as $model) {
                ++$sn;
                $modelacademic = backend\modules\allocation\models\base\LearningInstitution::findone($model->learning_institution_id);
//   print_r($modelacademic);
//   die();
                if ($model->learning_institution_id > 0 && $model->guarantor_type == 1) {
                    $model->organization_type = 1;
                } else if ($model->learning_institution_id == "" && $model->guarantor_type == 1) {
                    $model->organization_type = 2;
                }

                if ($model->guarantor_type == 1 && $model->organization_type>1) {
                    ################################ Organization ####################
                    ############################@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@##
                         $type_o="";
                        if($model->organization_type==2){
                            $type_o=" Non-Academic ";  
                          }
                         else if($model->organization_type==3) {
                           $type_o="Other ";      
                         }
                    $attributes = [
                        [
                            'group' => true,
                            'label' => " Organization Details [ $type_o ] " . $sn . ': ' . Html::a('EDIT', ['/application/applicant-associate/guarantor-update', 'id' => $model->applicant_associate_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->applicant_associate_id,'url'=>'guarantor-view'], [
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
                                    'label' => 'Organization Name',
                                    'value' => $model->organization_name,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                    //'valueColOptions' => ['style' => 'width:30%'],
                                ],
                                 
                            ],
                        ],
//                        [
//                            'columns' => [
//
//                                [
//                                    'label' => 'Organization Type',
//                                    'value' => $type_o,
//                                    'labelColOptions' => ['style' => 'width:20%'],
//                                    //'valueColOptions' => ['style' => 'width:30%'],
//                                ],
//                                 
//                            ],
//                        ],
                        [
                            'columns' => [

                                [
                                    'label' => 'Postal Address',
                                    'value' => $model->postal_address,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                    'valueColOptions' => ['style' => 'width:30%'],
                                ],
                                [
                                    'label' => 'Phone Number',
                                    'value' => $model->phone_number,
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:40%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [

                                [
                                    'label' => 'Physical Address',
                                    'value' => $model->physical_address,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                    'valueColOptions' => ['style' => 'width:30%'],
                                ],
                                [
                                    'label' => 'Email Address',
                                    'value' => $model->email_address,
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:40%'],
                                ],
                            ],
                        ],
                   
                               [
               'columns' => [

                     [
                        'label' => 'Region',
                        'value' => $model->ward_id>0?$model->ward->district->region->region_name:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:80%'],
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
           
                        [
                            'group' => true,
                            'label' => "Contact Person Details ",
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
                        [
                            'columns' => [

                                [
                                    'label' => 'First Name',
                                    'value' => $model->firstname,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                    'valueColOptions' => ['style' => 'width:30%'],
                                ],
                                [
                                    'label' => 'Middle Name',
                                    'value' => $model->middlename,
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:40%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [

                                [
                                    'label' => 'Surname',
                                    'value' => $model->surname,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                  //  'valueColOptions' => ['style' => 'width:30%'],
                                ],
                            ],
                        ],
                    ];
                } else {
                    ############################## Personal Guarantor###################
                    ##########@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@##############
                    $attributes = [
                        [
                            'group' => true,
                            'label' => " Guarantor Details " . $sn . ': ' . Html::a('EDIT', ['/application/applicant-associate/guarantor-update', 'id' => $model->applicant_associate_id,'url'=>'guarantor-view'], ['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->applicant_associate_id,'url'=>'guarantor-view'], [
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
                        'label' => 'Identification Type',
                        'value' => $model->identification_type_id>0?$model->identificationType->identification_type:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                   [
                        'label' => 'Identifaction Number',
                        'value' => $model->NID,
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
                if ($model->learning_institution_id > 0 && $model->guarantor_type == 1) {
                    $attributes = [
                        [
                            'group' => true,
                            'label' => "Organization Details [ Academic ] " . $sn . ': ' . Html::a('EDIT', ['/application/applicant-associate/guarantor-update', 'id' => $model->applicant_associate_id],['class' => 'btn btn-primary']) . ' &nbsp;&nbsp; ' .Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->applicant_associate_id,'url'=>'guarantor-view'], [
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
                                    'label' => 'Institution Name',
                                    'value' => $modelacademic->institution_name,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                    'valueColOptions' => ['style' => 'width:30%'],
                                ],
                                [
                                    'label' => 'Institution Code',
                                    'value' => $modelacademic->institution_code,
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:40%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'label' => 'Physical Address',
                                    'value' => $model->physical_address,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                    'valueColOptions' => ['style' => 'width:30%'],
                                ],
                                [
                                    'label' => 'Phone Number',
                                    'value' => $model->phone_number,
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:40%'],
                                ],
                            ],
                        ],
                        [
                            'group' => true,
                            'label' => " Contact Person Details",
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
                        [
                            'columns' => [

                                [
                                    'label' => 'First Name',
                                    'value' => $modelacademic->cp_firstname,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                    'valueColOptions' => ['style' => 'width:30%'],
                                ],
                                [
                                    'label' => 'Middle Name',
                                    'value' => $modelacademic->cp_middlename,
                                    'labelColOptions' => ['style' => 'width:15%'],
                                    'valueColOptions' => ['style' => 'width:40%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [

                                [
                                    'label' => 'Surname',
                                    'value' => $modelacademic->cp_surname,
                                    'labelColOptions' => ['style' => 'width:20%'],
                                    'valueColOptions' => ['style' => 'width:30%'],
                                ],
                            ],
                        ],
                    ];
                    echo DetailView::widget([
                        'model' => $modelacademic,
                        'condensed' => true,
                        'hover' => true,
                        'mode' => DetailView::MODE_VIEW,
                        'attributes' => $attributes,
                    ]);
                } else {
                    echo DetailView::widget([
                        'model' => $model,
                        'condensed' => true,
                        'hover' => true,
                        'mode' => DetailView::MODE_VIEW,
                        'attributes' => $attributes,
                        
                    ]);
                }
           //echo $model->passport_photo;
                      if($model->guarantor_type>1){
                $fileimage=$model->file_path.$model->passport_photo;
           echo "<table border='0'  style='float:right;width:100%' class='table table-striped table-bordered table-hover'>"
			."<tr height = '150px'><td width = 120px;><center><input type='image' src='{$fileimage}' style='width:200px;height:160px' value=''</center></td></tr>"
			 ."<tr><td style='text-align:center'></td></tr>"
			."</table> ";
                      }
                      ?>
            <table id="example2" class="table table-bordered table-hover">
            
                    <tbody>
                   <?php  
                 //  echo "Mickidadi ".$model->identification_document;
                   if($model->identification_document!=""){ 
                       echo "<tr>
                                <td colspan='2'><b>Identification Document</b> </td>
                              
                              </tr>";
                           echo '<tr><td colspan="2">
           <iframe src="'.$model->identification_document.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                         }
            
                      ?>
                    </tbody>
                    
                  </table> 
            <?php
            
                   }
            ?>
              
 <div class="col-lg-12">
  <?= Html::a('<< Go Previous Step', ['applicant-associate/guardian-view'], ['class' => 'pull-left']) ?>
  
  <?= Html::a('Go Next Step>>', ['application/view-application','id'=>$modelApplication->application_id], ['class' => 'pull-right']) ?>
 
            </div> 
        </div>
    </div>
</div>