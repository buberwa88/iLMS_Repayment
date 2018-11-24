<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QtriggerMain $model
 */

$this->title = $model->qtrigger_main_id;
$this->params['breadcrumbs'][] = ['label' => 'Qtrigger Mains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qtrigger-main-view">
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
            'qtrigger_main_id',
            'description',
            'join_operator',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->qtrigger_main_id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
