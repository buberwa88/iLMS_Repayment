<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementUserStructure */

$this->title = $model->disbursement_user_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Disbursement User Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-user-structure-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->disbursement_user_structure_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->disbursement_user_structure_id], [
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
            'disbursement_user_structure_id',
            'disbursement_structure_id',
            'user_id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'deleted_by',
            'deleted_at',
            'status',
        ],
    ]) ?>

</div>
