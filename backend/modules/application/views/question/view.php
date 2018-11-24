<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\Question $model
 */

//$this->title = $model->question_id;
//$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">
    <?= DetailView::widget([
        'model' => $model,
        'condensed' =>true,
        'hover' => true,
       // 'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
           // 'question_id',
            'question',
            'response_control',
            'response_data_type',
            'response_data_length',
            'hint',
            'qresponse_source_id',
            'require_verification',
            'verification_prompt',
            //'is_active',
        ],
//        'deleteOptions' => [
//            'url' => ['delete', 'id' => $model->question_id],
//        ],
        'enableEditMode' => FALSE,
    ]) ?>

</div>
