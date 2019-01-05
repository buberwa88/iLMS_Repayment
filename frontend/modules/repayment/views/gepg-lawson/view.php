<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\GepgLawson */

$this->title = $model->gepg_lawson_id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Lawsons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-lawson-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->gepg_lawson_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->gepg_lawson_id], [
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
            'gepg_lawson_id',
            'bill_number',
            'amount',
            'control_number',
            'control_number_date',
            'deduction_month',
            'status',
            'gepg_date',
        ],
    ]) ?>

</div>
