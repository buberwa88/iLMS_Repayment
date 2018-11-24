<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\NatureOfWork */

$this->title = $model->nature_of_work_id;
$this->params['breadcrumbs'][] = ['label' => 'Nature Of Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nature-of-work-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->nature_of_work_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->nature_of_work_id], [
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
            'nature_of_work_id',
            'description',
        ],
    ]) ?>

</div>
