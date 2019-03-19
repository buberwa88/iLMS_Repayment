<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use frontend\modules\repayment\models\EmployerSearch;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Failed Uploaded Employees';
$this->params['breadcrumbs'][] = $this->title;
$loggedin = Yii::$app->user->identity->user_id;
$employer2 = EmployerSearch::getEmployer($loggedin);
$employerID = $employer2->employer_id;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
                            <div class="text-right">
                <?php
                $failedUploadedEmployees= \frontend\modules\repayment\models\EmployedBeneficiary::find()
                    ->where(['upload_status'=>0,'employer_id'=>$employerID])
                    ->count();
                if($failedUploadedEmployees > 0) {

                    echo Html::a('Export Excel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp', Url::toRoute(['export-failed-employee']));
                }
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
            
            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
            ],

        ],
    ]);
    ?>
</div>
       </div>
</div>