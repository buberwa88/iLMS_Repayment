<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanBeneficiary */

$this->title = "Loan Beneficiary";
$this->params['breadcrumbs'][] = ['label' => 'Loan Beneficiaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-beneficiary-view">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">  

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'loan_beneficiary_id',
                    'firstname',
                    'middlename',
                    'surname',
                    [
                        'attribute' => 'sex',
                        'label' => 'Gender',
                        'width' => '200px',
                        'format' => 'raw',
                        'value' => call_user_func(function ($data) {
                                    if ($data->sex == 'M') {
                                        return 'Male';
                                    } else if ($data->sex == 'F') {
                                        return 'Female';
                                    }
                                }, $model),
                    ],
                    'date_of_birth',
                    [
                        'attribute' => 'region',
                        'label' => 'Region',
                        'value' => $model->placeOfBirth->district->region->region_name,
                    ],
                    [
                        'attribute' => 'district',
                        'label' => 'District',
                        'value' => $model->placeOfBirth->district->district_name,
                    ],
                    [
                        'attribute' => 'place_of_birth',
                        'label' => 'ward',
                        'value' => $model->placeOfBirth->ward_name,
                    ],
                    'phone_number',
                    'postal_address',
                    'physical_address',
                    'email_address:email',
                    'f4indexno',
                    'NID',
                    //'learning_institution_id',
                    [
                        'attribute' => 'learning_institution_id',
                        'value' => $model->learningInstitution->institution_name,
                    ],
                    [
                        'attribute' => 'applicant_id',
                        'label' => 'Status',
                        'width' => '200px',
                        'format' => 'raw',
                        'value' => call_user_func(function ($data) {
                                    if ($model->applicant_id == '') {
                                        return '<p class="btn green"; style="color:red;">Pending Verification</p>';
                                    } else {
                                        return '<p class="btn green"; style="color:green;">Confirmed</p>';
                                    }
                                }, $model),
                    ],
                //'password',
                ],
            ])
            ?>
            <div class="text-right">
                <p>
                    <?= Html::a('Assign Valid Form IV Index Number', ['update', 'id' => $model->loan_beneficiary_id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['loan-beneficiary/index'], ['class' => 'btn btn-warning']) ?>
                </p>
            </div>
        </div>
    </div>
</div>
