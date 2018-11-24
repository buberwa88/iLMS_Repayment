<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\FinancialYear */

$this->title = $model->financial_year_id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="financial-year-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->financial_year_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->financial_year_id], [
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
            'financial_year_id',
            'financial_year',
            'is_active',
        ],
    ]) ?>

</div>
