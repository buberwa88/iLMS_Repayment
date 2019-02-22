<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Claimants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-claimant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Refund Claimant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'refund_claimant_id',
            'applicant_id',
            'claimant_user_id',
            'firstname',
            'middlename',
            // 'surname',
            // 'sex',
            // 'phone_number',
            // 'f4indexno',
            // 'completion_year',
            // 'old_firstname',
            // 'old_middlename',
            // 'old_surname',
            // 'old_sex',
            // 'old_details_confirmed',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            // 'is_active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
