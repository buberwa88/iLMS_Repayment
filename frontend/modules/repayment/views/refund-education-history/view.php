<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */

$this->title = $model->refund_education_history_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Education Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->refund_education_history_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->refund_education_history_id], [
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
            'refund_education_history_id',
            'refund_application_id',
            'program_id',
            'institution_id',
            'entry_year',
            'completion_year',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'is_active',
        ],
    ]) ?>

</div>