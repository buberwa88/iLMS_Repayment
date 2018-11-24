<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeCategory */

$this->title = $model->programme_category_id;
$this->params['breadcrumbs'][] = ['label' => 'Programme Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->programme_category_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->programme_category_id], [
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
            'programme_category_id',
            'programme_category_name',
            'programme_category_desc',
        ],
    ]) ?>

</div>
