<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenalty */

$this->title = $model->employer_penalty_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-penalty-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->employer_penalty_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->employer_penalty_id], [
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
            'employer_penalty_id',
            'employer_id',
            'amount',
            'penalty_date',
            'created_at',
        ],
    ]) ?>

</div>
