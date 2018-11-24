<?php

use yii\helpers\Html;
use kartik\grid\GridView;
 

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Loanee';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-index">
    <div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'applicant_id',
                [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'lastName',
                        'vAlign' => 'middle',
                         
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->user->surname;
                        },
                    ],
           // 'user_id',
            'NID',
            'f4indexno',
           // 'f6indexno',
            // 'mailing_address',
            // 'date_of_birth',
            // 'place_of_birth',
            // 'loan_repayment_bill_requested',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{viewprofile}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil" title="Edit"></span>',
                            $url);
                    },
                      'viewprofile' => function ($url,$model,$key) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open" title="Edit"></span>', $url);
                    },

                ],
                ],
        ],
      'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
    </div>
</div>