<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SectorDefinition */

$this->title ="View Sector Detail";
$this->params['breadcrumbs'][] = ['label' => 'Sector Definitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sector-definition-view">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sector_definition_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sector_definition_id], [
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
           // 'sector_definition_id',
            'sector_name',
            'sector_desc',
        ],
    ]) ?>

</div>
</div>
</div>