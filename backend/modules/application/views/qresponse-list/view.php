<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QresponseList $model
 */

$this->title = $model->qresponse_list_id;
$this->params['breadcrumbs'][] = ['label' => 'Qresponse Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qresponse-list-view">
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
            'qresponse_list_id',
            'response',
            'is_active',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->qresponse_list_id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
