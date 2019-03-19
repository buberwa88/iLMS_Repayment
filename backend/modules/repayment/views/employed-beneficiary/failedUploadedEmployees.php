<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Failed Uploaded Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-body">
                            <div class="text-right">
                <?php
echo Html::a('Export Excel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp', Url::toRoute(['employed-beneficiary/export-failed-employee','employerID'=>$employerID]));
                ?>
                </div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'employer.employer_name',
            [
                'attribute' => 'employee_id',
                'label' => "Employee ID/Check #",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->employee_id;
                },
            ],
            [
                'attribute' => 'firstname',
                'label' => "First Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->firstname;
                },
            ],
            /*
            [
                'attribute' => 'middlename',
                'label' => "Middle Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->middlename;
                },
            ],
            */
            [
                'attribute' => 'surname',
                'label' => "Last Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->surname;
                },
            ],
            [
                'attribute' => 'f4indexno',
                'label' => "Index Number",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->f4indexno;
                },
            ],
            [
                'attribute' => 'form_four_completion_year',
                'label' => "Completion Year",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->form_four_completion_year;
                },
            ],
            [
                'attribute' => 'upload_error',
                'label' => "Failed Reason",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->upload_error;
                },
            ],
            /*
            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
            ],
            */
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            //'class' => 'btn btn-info',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                //'method' => 'get',
                                //'title' => Yii::t('app', 'lead-update'),
                            ],
                        ]);
                    }

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url ='index.php?r=repayment/employed-beneficiary/view-upload&id='.$model->employed_beneficiary_id.'&employerID='.$model->employer_id;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url ='index.php?r=repayment/employed-beneficiary/update-upload&id='.$model->employed_beneficiary_id.'&employerID='.$model->employer_id;
                        return $url;
                    }
                    if ($action === 'delete') {
                        $url ='index.php?r=repayment/employed-beneficiary/delete-upload&id='.$model->employed_beneficiary_id.'&employerID='.$model->employer_id;
                        return $url;
                    }

                }
            ],
        ],
    ]);
    ?>
</div>
       </div>
</div>