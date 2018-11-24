<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerType */

$this->title = $model->employer_type;
$this->params['breadcrumbs'][] = ['label' => 'Employer Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->employer_type_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->employer_type_id], [
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
            'employer_type_id',
            'employer_type',
            'created_at',
            'is_active',
        ],
    ]) ?>

</div>
