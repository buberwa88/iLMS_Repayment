<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationReverse */

$this->title = $model->application_reverse_id;
$this->params['breadcrumbs'][] = ['label' => 'Application Reverses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-reverse-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->application_reverse_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->application_reverse_id], [
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
            'application_reverse_id',
            'application_id',
            'comment:ntext',
            'reversed_by',
            'reversed_at',
        ],
    ]) ?>

</div>
