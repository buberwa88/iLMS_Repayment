<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmittedStudent */

$this->title = $model->admitted_student_id;
$this->params['breadcrumbs'][] = ['label' => 'Admitted Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admitted-student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->admitted_student_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->admitted_student_id], [
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
            'admitted_student_id',
            'admission_batch_id',
            'f4indexno',
            'programme_id',
            'has_transfered',
        ],
    ]) ?>

</div>
