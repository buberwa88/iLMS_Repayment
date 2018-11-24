<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\Cnotification $model
 */

//$this->title = $model->cnotification_id;
//$this->params['breadcrumbs'][] = ['label' => 'Cnotifications', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cnotification-view">



    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            //'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
            'heading'=>  Html::a('[Back to List]', ['/application/cnotification/index']).'&nbsp;&nbsp;&nbsp;'.Html::a('[Edit]', ['/application/cnotification/update','id'=>$model->cnotification_id])
        ],
        'attributes' => [
            //'cnotification_id',
            'subject',
            [
              'attribute'=>'notification',
              'format'=>'raw',
            ],
           'date_created',
         
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->cnotification_id],
        ],
        'enableEditMode' => false,
    ]) ?>

</div>
