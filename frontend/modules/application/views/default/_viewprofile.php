
<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = "Basic  Details";
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'user_id',
            'firstname',
            'middlename',
            'surname',
            'sex',
            'username',
           // 'password_hash',
           // 'security_question_id',
         //   'security_answer',
            'email_address:email',
         //   'passport_photo',
            'phone_number',
//            'is_default_password',
//            'status',
//            'status_comment:ntext',
//            'login_counts',
//            'last_login_date',
//            'date_password_changed',
//            'auth_key',
//            'password_reset_token',
//            'activation_email_sent:email',
//            'email_verified:email',
//            'created_at',
//            'updated_at',
//            'created_by',
//            'login_type',
        ],
    ]); 
      
?>
    <?= DetailView::widget([
        'model' => $modelall,
        'attributes' => [
           // 'identificationType.identification_type',
              
                [
                'columns' => [
                      [
                        'label' => 'Identification Type',
                        'value' => $modelall->identificationType->identification_type,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
          //  'NID',
              [
                'columns' => [
                      [
                        'label' => 'Identification Number (Non-mandatory)',
                        'value' => $modelall->NID,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
              [
                            'group' => true,
                            'label' => 'Domicile Details',
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
                [
                'columns' => [
                      [
                        'label' => 'Region Name',
                        'value' => $modelall->warddomicile->district->region->region_name,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
          //  'warddomicile.district.region.region_name',
           // 'warddomicile.district.district_name',
               [
                'columns' => [
                      [
                        'label' => 'District Name',
                        'value' => $modelall->warddomicile->district->district_name,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
            //'warddomicile.ward_name',
             [
                'columns' => [
                      [
                        'label' => 'Ward',
                        'value' => $modelall->warddomicile->ward_name,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
          // 'f4indexno',
            
                        [
                'columns' => [
                      [
                        'label' => 'Physical Address',
                        'value' => $modelall->physical_address,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
             [
                'columns' => [
                      [
                        'label' => 'Postal Address',
                        'value' => $modelall->mailing_address,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
           [
                'columns' => [
                      [
                        'label' => 'Village/Street',
                        'value' => $modelall->village_domicile,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ], 
           [
                            'group' => true,
                            'label' => 'Place of Birth  Details',
                            'rowOptions' => ['class' => 'info'],
                            'format' => 'raw',
                        ],
            [
                'columns' => [
                      [
                        'label' => 'Date of Birth',
                        'value' => $modelall->date_of_birth,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
                         [
                'columns' => [
                      [
                        'label' => 'Birth Region',
                        'value' => $modelall->ward->district->region->region_name,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
     
               [
                'columns' => [
                      [
                        'label' => 'Birth District',
                        'value' => $modelall->ward->district->district_name,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
            //'warddomicile.ward_name',
             [
                'columns' => [
                      [
                        'label' => 'Birth Ward',
                        'value' => $modelall->ward->ward_name,
                        'labelColOptions'=>['style'=>'width:40%'],
                        'valueColOptions'=>['style'=>'width:60%'],
                    ],
                ],
            ],
           
 
        ],
    ]); 
                   
     ?>
  
</div>