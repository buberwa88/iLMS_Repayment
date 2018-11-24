<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-beneficiary-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Loan Beneficiary', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'loan_beneficiary_id',
            'firstname',
            'middlename',
            'surname',
            'f4indexno',
            // 'NID',
            // 'date_of_birth',
            // 'place_of_birth',
            // 'learning_institution_id',
            // 'postal_address',
            // 'physical_address',
            // 'phone_number',
            // 'email_address:email',
            // 'password',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
