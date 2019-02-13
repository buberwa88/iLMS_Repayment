<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Verifications Assignments';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel-body">
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
                'label' => "Demographics",
                'rowOptions' => ['class' => 'info']
            ],
            [
                'label' => "f4 Index #",
                'value' => $model->applicant->f4indexno,
            ],
            [
                'label' => "First Name",
                'value' => $model->applicant->user->firstname,
            ],
            [
                'label' => "Middle Name",
                'value' => $model->applicant->user->middlename,
            ],
            [
                'label' => "Surname",
                'value' => $model->applicant->user->surname,
            ],
            [
                'label' => 'Gender',
                'value' => call_user_func(function ($data) {
                            if ($data->applicant->user->sex == 'F') {
                                return 'Female';
                            } else if ($data->applicant->user->sex == 'M') {
                                return 'Male';
                            } else {
                                return '';
                            }
                        }, $model),
            ],
            [
                'label' => "Date of Birth",
                'value' => $model->applicant->date_of_birth,
            ],
            [
                'group' => true,
                'label' => "Contact Information",
                'rowOptions' => ['class' => 'info']
            ],
            [
                'label' => "Mobile Phone #",
                'value' => $model->applicant->user->phone_number,
            ],
            [
                'label' => "Email",
                'value' => $model->applicant->user->email_address,
            ],
            [
                'label' => "Region",
                'value' => $model->applicant->ward->district->region->region_name,
            ],
            [
                'label' => "District",
                'value' => $model->applicant->ward->district->district_name,
            ],
            [
                'label' => "Ward",
                'value' => $model->applicant->ward->ward_name,
            ],
            [
                'label' => "Postal Adress",
                'value' => $model->applicant->mailing_address,
            ],
            [
                'group' => true,
                'label' => "Place Of Domicile",
                'rowOptions' => ['class' => 'info']
            ],
            [
                'label' => "Region",
                'value' => $model->applicant->placeOfDomicile->district->region->region_name,
            ],
            [
                'label' => "District",
                'value' => $model->applicant->placeOfDomicile->district->district_name,
            ],
            [
                'label' => "Ward",
                'value' => $model->applicant->placeOfDomicile->ward_name,
            ],
            [
                'label' => "Village",
                'value' => $model->applicant->village_domicile,
            ],
        ],
    ])
    ?>
</div>

