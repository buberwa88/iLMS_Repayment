<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LawsonMonthlyDeductionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lawson Monthly Deductions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lawson-monthly-deduction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Lawson Monthly Deduction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'lawson_monthly_deduction_id',
            'ActualBalanceAmount',
            'CheckDate',
            'CheckNumber',
            'DateHired',
            // 'DeductionAmount',
            // 'DeductionCode',
            // 'DeductionDesc',
            // 'DeptName',
            // 'FirstName',
            // 'LastName',
            // 'MiddleName',
            // 'NationalId',
            // 'Sex',
            // 'VoteName',
            // 'Votecode',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
