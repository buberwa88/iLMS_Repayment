<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SectorProgramme */

$this->title ="View Section Programme Detail";
$this->params['breadcrumbs'][] = ['label' => 'Sector Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sector-programme-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sector_programme_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sector_programme_id], [
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
           // 'sector_programme_id',
            'sectorDefinition.sector_name',
            'academicYear.academic_year',
            'programme.programme_code',
        ],
    ]) ?>

</div>
 </div>
</div>