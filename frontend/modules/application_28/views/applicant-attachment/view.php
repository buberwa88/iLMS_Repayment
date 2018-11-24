<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\ApplicantAttachment $model
 */

$this->title = $model->applicant_attachment_id;
$this->params['breadcrumbs'][] = ['label' => 'Applicant Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-attachment-view">
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
            'applicant_attachment_id',
            'application_id',
            'attachment_definition_id',
            'attachment_path',
            'verification_status',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->applicant_attachment_id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
