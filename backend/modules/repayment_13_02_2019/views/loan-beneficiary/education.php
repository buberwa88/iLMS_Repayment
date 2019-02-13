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
            /*
            [
                        'label'=>"Institution",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->learningInstitution->institution_name;
                        },
                    ],
             * 
             */ 
            [
                        'label'=>"Level",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->level;
                        },
                    ], 
            [
                        'label'=>"Registration #",
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->registration_number !=''){
                        return $model->registration_number.".".$model->completion_year;
                            }else{
                        return '';        
                            }
                        },
                    ],                    
            [
                        'label'=>"Completion Year",
                        'format' => 'raw',
                        'value' => function ($model) {
                        return $model->completion_year;
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
