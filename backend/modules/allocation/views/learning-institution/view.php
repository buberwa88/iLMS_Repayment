<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitution */

//$this->title ="Learning Institution Detail";
//$this->params['breadcrumbs'][] = ['label' => 'Learning Institutions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.detail-view th {
        width: 60%;
    }

    table.detail-view td {
        width: 40%;
    }
</style>
<div class="learning-institution-view">
 
        <div class="panel panel-info">
            <div class="panel-heading">
                Institution Detail
            </div>
            <div class="panel-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    // 'condensed' => true,
                    //'hover' => true,
                    'attributes' => [
                        // 'learning_institution_id',
                        'institution_type',
                        'institution_code',
                        'institution_name',
                        // 'parent.institution_name',
                        'phone_number',
                        'physical_address',
                        // 'ward_id',
                        'bank_account_number',
                        'bank_account_name',
                        //'bank_id',
                        'bank_branch_name',
                    // 'entered_by_applicant',
                    //'created_at',
                    // 'created_by',
                    ],
                    'template' => '<tr><th style="width:60%;">{label}</th><td>{value}</td></tr>',
                ])
                ?>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading">
                Contact Personal Detail
            </div>
            <div class="panel-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'condensed' => true,
                    'hover' => true,
                    'attributes' => [
                        // 'learning_institution_id',
                        // 'entered_by_applicant',
                        //'created_at',
                        // 'created_by',
                        'cp_firstname',
                        'cp_middlename',
                        'cp_surname',
                        'cp_email_address:email',
                        'cp_phone_number',
                    ],
                ])
                ?>
            </div>
        </div>

    </div>
