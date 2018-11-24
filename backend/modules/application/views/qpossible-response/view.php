<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QpossibleResponse $model
 */

$this->title = $model->qpossible_response_id;
$this->params['breadcrumbs'][] = ['label' => 'Qpossible Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qpossible-response-view">
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
            'qpossible_response_id',
            'question_id',
            'qresponse_list_id',
           // 'attachment_definition_id',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->qpossible_response_id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
