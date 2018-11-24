<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Criteria */

$this->title = "View Criteria Detail";
$this->params['breadcrumbs'][] = ['label' => 'Criteria', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-view">

    <?php 
//   =DetailView::widget([
//        'model' => $model,
//        'condensed' => false,
//        'hover' => true,
//        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
//        'panel' => [
//            'heading' => $this->title,
//            'type' => DetailView::TYPE_INFO,
//        ],
//        'attributes' => [
//            'criteria_id',
//            'criteria_description',
//            'is_active',
//        ],
//        'deleteOptions' => [
//            'url' => ['delete', 'id' => $model->criteria_id],
//        ],
//        'enableEditMode' => true,
//    ])
            ?>
   <?= DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'attributes' => [
            // 'criteria_id',
            'criteria_description',
           // 'is_active',
               [
            'label' => 'Status',
            'value' => $model->is_active==1?"Active":"Inactive",
            //'labelColOptions'=>['style'=>'width:20%'],
            //'valueColOptions'=>['style'=>'width:30%'],
                    ],
        ],
    ]) ?>
</div>