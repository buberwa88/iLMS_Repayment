<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\QresponseSource */

        $this->title ="View Question Response Source Detail";
$this->params['breadcrumbs'][] = ['label' => 'Qresponse Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qresponse-source-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->qresponse_source_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->qresponse_source_id], [
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
           // 'qresponse_source_id',
            'source_table',
            'source_table_value_field',
            'source_table_text_field',
        ],
    ]) ?>

</div>
 </div>
</div>