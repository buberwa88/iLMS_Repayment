<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeFee */

//$this->title ="Programme Fee Details";
//$this->params['breadcrumbs'][] = ['label' => 'Programme Fees', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-fee-view">
<div class="panel panel-info">
        <div class="panel-heading">
     
        </div>
        <div class="panel-body">
     

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'programme_fee_id',
            'academicYear.academic_year',
            'programme.learningInstitution.institution_name',
            'programme.programme_code',
            'loanItem.item_name',
            'amount',
            'days',
            'year_of_study',
        ],
    ]) ?>

</div>
</div>
</div>