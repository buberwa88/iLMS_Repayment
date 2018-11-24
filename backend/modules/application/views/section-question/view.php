<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\SectionQuestion $model
 */

$this->title = $model->section_question_id;
$this->params['breadcrumbs'][] = ['label' => 'Section Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-question-view">
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
            'section_question_id',
            'applicant_category_section_id',
            'question_id',
            'attachment_definition_id',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->section_question_id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
