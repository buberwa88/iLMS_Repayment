<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\application\models\ApplicantAssociateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Applicant Associates';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-associate-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                        'label'=>"Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->firstname." ".$model->middlename." ".$model->surname;
                        },
                    ],                               
                                [
                        'label'=>"Sex",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->sex;
                        },
                    ],
                                [
                        'label'=>"Phone #",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->phone_number;
                        },
                    ],
                                [
                        'label'=>"Postal Address",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->postal_address;
                        },
                    ],
                                [
                        'label'=>"Email",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->email_address;
                        },
                    ],
            [
                        'label'=>"Occupation",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->occupation->occupation_desc;
                        },
                    ],                    
            [
                        'label'=>"Type",
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->type=='PR'){
                               return 'Parent'; 
                            }else if($model->type=='GA'){
                              return 'Guarantor';  
                            }else if($model->type=='GD'){
                              return 'Guardian'; 
                            }
                        },
                    ],                    
            // 'phone_number',
            // 'physical_address',
            // 'email_address:email',
            // 'NID',
            // 'occupation_id',
            // 'passport_photo',
            // 'type',
            // 'learning_institution_id',
            // 'ward_id',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
