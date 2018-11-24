<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationCustomCriteria */

$this->title = $model->verification_custom_criteria_id;
$this->params['breadcrumbs'][] = ['label' => 'Verification Custom Criterias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-custom-criteria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->verification_custom_criteria_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->verification_custom_criteria_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'verification_custom_criteria_id',
            'verification_framework_id',
            'criteria_name',
            'applicant_source_table',
            'applicant_souce_column',
            'applicant_source_value',
            'operator',
            'created_by',
            'created_at',
        ],
    ]) ?>

</div>
