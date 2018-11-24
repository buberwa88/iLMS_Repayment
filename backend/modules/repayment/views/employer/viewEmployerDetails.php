<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = "Employer: " . $model->employer_name;
$this->params['breadcrumbs'][] = ['label' => 'Employers', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Employer';
?>
<div class="employer-view">
    <div class="panel panel-info">
        <div class="panel-body">
            <?php
            $results1 = $model->getTotalEmployees($model->employer_id);
            ?>
            <?=
            DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => true,
                'mode' => DetailView::MODE_VIEW,
                'attributes' => [
                    //'employer_id',
                    //'user_id',
                    [
                        'group' => true,
                        'label' => "Employer Details",
                        'rowOptions' => ['class' => 'info']
                    ],
                    'employer_name',
                    'short_name',
                    [
                        'attribute' => 'TIN',
                        'label' => 'TIN',
                        'value' => $model->TIN,
                    ],
                    [
                        'attribute' => 'employer_type_id',
                        'value' => $model->employerType->employer_type,
                    ],
                    [
                        'attribute' => 'nature_of_work_id',
                        'label' => 'Sector',
                        'value' => $model->natureOfWork->description,
                    ],
                    'postal_address',
                    'physical_address',
                    [
                        'attribute' => 'region',
                        'label' => 'Region',
                        'value' => $model->ward->district->region->region_name,
                    ],
                    [
                        'attribute' => 'district',
                        'label' => 'District',
                        'value' => $model->ward->district->district_name,
                    ],
                    [
                        'attribute' => 'ward_id',
                        'label' => 'ward',
                        'value' => $model->ward->ward_name,
                    ],
                    [
                        'attribute' => 'phone_number',
                        'label' => 'Telephone Number',
                        'value' => $model->phone_number,
                    ],
                    'fax_number',
                    [
                        'attribute' => 'email_address',
                        'label' => 'Office Email Address',
                        'value' => $model->email_address,
                    ],
                    [
                        'group' => true,
                        'label' => "Contact Person Details",
                        'rowOptions' => ['class' => 'info']
                    ],
                    [
                        'attribute' => 'user_id',
                        'label' => 'Name',
                        'value' => $model->user->firstname . ", " . $model->user->middlename . " " . $model->user->surname,
                    ],
                    [
                        'attribute' => 'phone_number',
                        'label' => 'Telephone Number',
                        'value' => $model->user->phone_number,
                    ],
                    [
                        'attribute' => 'email_address',
                        'label' => 'Email Address',
                        'value' => $model->user->email_address,
                    ],
                    [
                        'label' => 'Status',
                        'value' => call_user_func(function ($data) {
                                    if ($data->verification_status == 0) {
                                        return 'Pending Verification';
                                    } else if ($data->verification_status == 1) {
                                        return 'Confirmed';
                                    } else if ($data->verification_status == 3) {
                                        return 'Deactivated';
                                    } else {
                                        return '';
                                    }
                                }, $model),
                    ],
                ],
            ])
            ?>
            <div class="text-right">
                <?php if ($model->verification_status != 1 && $model->verification_status != 3) { ?>
                    <?= Html::a('Confirm', ['employer-confirmheslb', 'employerID' => $model->employer_id, 'actionID' => '1'], ['class' => 'btn btn-success']) ?>      
                <?php } ?>
                <?=
                Html::a('Deactivate', ['employer-confirmheslb', 'employerID' => $model->employer_id, 'actionID' => '3'], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to deactivate this employer?',
                        'method' => 'post',
                    ],
                ])
                ?>
                <?php if ($model->verification_status == 2) { ?>
                    <?=
                    Html::a('Activate Acount', ['activate-accountheslb', 'employerID' => $model->employer_id], [
                        'class' => 'btn btn-primary',
                        'data' => [
                            'confirm' => 'Are you sure you want to Activate this employer?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                <?php } ?>
                <?= Html::a('Cancel', ['employer-verification-status', 'employerID' => $model->employer_id, 'actionID' => '0'], ['class' => 'btn btn-warning']) ?>
            </div>
        </div>
    </div>
</div>
