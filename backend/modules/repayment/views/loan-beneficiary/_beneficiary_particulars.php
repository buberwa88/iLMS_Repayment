<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<?=

DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'name',
            'value' => $model->applicant->user->firstname . '  ' . $model->applicant->user->middlename . ' ' . $model->applicant->user->surname
        ],
        ['attribute' => 'f4indexno',
            'value' => $model->applicant->f4indexno
        ],
        ['attribute' => 'NID',
            'value' => $model->applicant->NID
        ],
        [
            'attribute' => 'sex',
            'value' => $model->applicant->sex == 'M' ? 'Male' : 'Female'
        ],
        [
            'attribute' => 'date_of_birth',
            'value' => $model->applicant->date_of_birth ? Date('d, D-M-Y', strtotime($model->applicant->date_of_birth)) : ''
        ],
        ['attribute' => 'phone_number',
            'value' => $model->applicant->user->phone_number
        ],
        [
            'attribute' => 'loan_confirmation_status',
            'label' => 'Loan Confirmation',
            'value' => common\models\LoanBeneficiary::getLoanConfirmationStatusNameByApplicantID($model->applicant->applicant_id)
        ],
        ['attribute' => 'liquidation_letter_status',
            'label' => 'Liquidation Letter',
            'value' => common\models\LoanBeneficiary::getLiqudationStatusNameByApplicantID($model->applicant->applicant_id)
        ],
        [
            'attribute' => 'applicant_id',
            'label' => 'Status',
            'width' => '200px',
            'format' => 'raw',
            'value' => call_user_func(function ($data) {
                        if ($data->applicant_id == '') {
                            return '<p class="btn green"; style="color:red;">Pending Verification</p>';
                        } else {
                            return '<p class="btn green"; style="color:green;">Confirmed</p>';
                        }
                    }, $model),
        ],
    //'password',
    ],
]);
?>  



