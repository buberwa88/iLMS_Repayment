<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementSetting */

$this->title = "View Instalment Setting per Loan Item";
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-setting-view">
  <div class="panel panel-info">
        <div class="panel-heading">
         <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->disbursement_setting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->disbursement_setting_id], [
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
            //'disbursement_setting_id',
            'academicYear.academic_year',
            'instalmentDefinition.instalment',
            'loanItem.item_name',
            'percentage',
        ],
    ]) ?>

</div>
  </div>
</div>