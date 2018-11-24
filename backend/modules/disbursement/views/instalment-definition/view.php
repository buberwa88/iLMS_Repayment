<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\InstalmentDefinition */

$this->title ="View Instalment Details";
$this->params['breadcrumbs'][] = ['label' => 'Instalment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instalment-definition-view">
    <div class="panel panel-info">
        <div class="panel-heading">
         <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->instalment_definition_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->instalment_definition_id], [
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
           // 'instalment_definition_id',
            'instalment',
            'instalment_desc',
            'is_active',
        ],
    ]) ?>

</div>
    </div>
</div>