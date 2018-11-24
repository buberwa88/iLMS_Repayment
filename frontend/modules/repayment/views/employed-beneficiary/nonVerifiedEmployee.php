<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Un-verified employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">

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
                    return $model->firstname;
                },
            ],
            [
                'attribute' => 'middlename',
                'label' => "Middle Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->middlename;
                },
            ],
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
            ],
        ],
    ]);
    ?>
</div>
       </div>
</div>