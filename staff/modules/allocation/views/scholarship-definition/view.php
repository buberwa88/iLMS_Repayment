<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipDefinition */

$this->title = $model->scholarship_id;
$this->params['breadcrumbs'][] = ['label' => 'Scholarship Definitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scholarship-definition-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->scholarship_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->scholarship_id], [
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
            'scholarship_id',
            'scholarship_name',
            'scholarship_desc',
            'sponsor',
            'country_of_study',
            'start_year',
            'end_year',
            'is_active',
            'closed_date',
            'is_full_scholarship',
        ],
    ]) ?>

</div>
