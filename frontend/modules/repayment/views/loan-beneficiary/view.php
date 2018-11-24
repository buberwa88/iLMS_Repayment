<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanBeneficiary */

$this->title = $model->loan_beneficiary_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-beneficiary-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->loan_beneficiary_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->loan_beneficiary_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'loan_beneficiary_id',
            'firstname',
            'middlename',
            'surname',
            'f4indexno',
            'NID',
            'date_of_birth',
            'place_of_birth',
            'learning_institution_id',
            'postal_address',
            'physical_address',
            'phone_number',
            'email_address:email',
            'password',
        ],
    ]) ?>

</div>
