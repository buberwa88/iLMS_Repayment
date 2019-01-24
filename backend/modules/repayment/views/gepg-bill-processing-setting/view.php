<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgBillProcessingSetting */

$this->title = $model->gepg_bill_processing_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Bill Processing Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-bill-processing-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->gepg_bill_processing_setting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->gepg_bill_processing_setting_id], [
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
            'gepg_bill_processing_setting_id',
            'bill_type',
            'bill_processing_uri',
            'bill_prefix',
            'operation_type',
            'created_by',
            'created_at',
        ],
    ]) ?>

</div>
