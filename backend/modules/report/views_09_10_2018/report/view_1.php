<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\Report */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'name',
            'category',
            'file_name',
            'field1',
            'field2',
            'field3',
            'field4',
            'field5',
            'type1',
            'type2',
            'type3',
            'type4',
            'type5',
            'description1',
            'description2',
            'description3',
            'description4',
            'description5',
            'sql:ntext',
            'sql_where:ntext',
            'sql_order:ntext',
            'sql_group:ntext',
            'column1',
            'column2',
            'column3',
            'column4',
            'column5',
            'condition1',
            'condition2',
            'condition3',
            'condition4',
            'condition5',
            'package:ntext',
        ],
    ]) ?>

</div>
