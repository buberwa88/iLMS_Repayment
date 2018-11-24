<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'employer.employer_name',
            [
                'attribute' => 'firstname',
                'label' => "First Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->applicant->user->firstname;
                },
            ],
            [
                'attribute' => 'middlename',
                'label' => "Middle Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->applicant->user->middlename;
                },
            ],
            [
                'attribute' => 'surname',
                'label' => "Surname",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->applicant->user->surname;
                },
            ],
            [
                'attribute' => 'f4indexno',
                'label' => "Index Number",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->applicant->f4indexno;
                },
            ],
            [
                'attribute' => 'basic_salary',
                'label' => "Basic Salary(TZS)",
                'hAlign' => 'right',
                'width' => '200px',
                'format' => ['decimal', 2],
                'value' => function ($model) {
            return $model->basic_salary;
        },
                'filter' => '',
            ],
            [
                'attribute' => 'employment_status',
                //'vAlign' => 'middle',                         
                'width' => '200px',
                'value' => function($model) {
                    return $model->employment_status;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ['ONPOST' => 'ONPOST', 'TERMINATED' => 'TERMINATED', 'RETIRED' => 'RETIRED', 'DECEASED' => 'DECEASED'],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Search'],
                'format' => 'raw'
            ],
            [
                'attribute' => 'loan_summary_id',
                'header' => 'Status',
                'filter' => '',
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->loan_summary_id == '') {
                        return '<p class="btn green"; style="color:red;">Pending Verification</p>';
                    } else {
                        return '<p class="btn green"; style="color:green;">Confirmed</p>';
                    }
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{view}{update}'],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode('Verified Beneficiaries') . ' </h3>',
            'type' => 'info',
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => true
        ],
    ]);
    ?>
</div>