<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QresponseSource $model
 */

$this->title = $model->qresponse_source_id;
$this->params['breadcrumbs'][] = ['label' => 'Qresponse Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qresponse-source-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'qresponse_source_id',
            'source_table',
            'source_table_value_field',
            'source_table_text_field',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->qresponse_source_id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
