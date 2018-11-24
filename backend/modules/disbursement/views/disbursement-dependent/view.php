<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementDependent */

$this->title ="View Loan Item Associate";
$this->params['breadcrumbs'][] = ['label' => 'List Loan Item Associate', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-dependent-view">
  <div class="panel panel-info">
        <div class="panel-heading">
         <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->disbursement_setting2_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->disbursement_setting2_id], [
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
           // 'disbursement_setting2_id',
            'academicYear.academic_year',
            'instalmentDefinition.instalment',
            'loanItem.item_name',
            'associatedLoanItem.item_name',
        ],
    ]) ?>

</div>
  </div>
</div>