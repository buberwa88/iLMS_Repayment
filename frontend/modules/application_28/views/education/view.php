<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 */

$this->title = $model->education_id;
$this->params['breadcrumbs'][] = ['label' => 'Educations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="education-view">
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
            'education_id',
            'application_id',
            'level',
            'learning_institution_id',
            'registration_number',
            'programme_name',
            'programme_code',
            'entry_year',
            'completion_year',
            'division',
            'points',
            'is_necta',
            'class_or_grade',
            'gpa_or_average',
            'avn_number',
            'under_sponsorship',
            'sponsor_proof_document',
            'olevel_index',
            'alevel_index',
            'institution_name',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->education_id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
