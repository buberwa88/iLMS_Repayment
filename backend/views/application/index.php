<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Application', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'application_id',
            'applicant_id',
            'academic_year_id',
            'bill_number',
            'control_number',
            // 'receipt_number',
            // 'amount_paid',
            // 'pay_phone_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'date_receipt_received',
            // 'programme_id',
            // 'application_study_year',
            // 'current_study_year',
            // 'applicant_category_id',
            // 'bank_account_number',
            // 'bank_account_name',
            // 'bank_id',
            // 'bank_branch_name',
            // 'submitted',
            // 'verification_status',
            // 'needness',
            // 'allocation_status',
            // 'allocation_comment',
            // 'student_status',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
