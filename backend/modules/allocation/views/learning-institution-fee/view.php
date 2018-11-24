<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitutionFee */

$this->title = "View School Fees Detail";
$this->params['breadcrumbs'][] = ['label' => 'School Fees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-fee-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->learning_institution_fee_id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->learning_institution_fee_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'academicYear.academic_year',
                    'learningInstitution.institution_name',
                    [
                        'attribute' => 'study_level',
                        'hAlign' => 'right',
                        'value' => \backend\modules\allocation\models\LearningInstitution::getStudyLevelNameByValue($model->study_level),
                        'width' => '200px',
                    ],
                    [
                        'attribute' => 'fee_amount',
                        'hAlign' => 'right',
                        'format' => ['decimal', 2],
                        //'label'=>"Status",
                        'width' => '200px',
                    ],
                    'created_at',
                    'createdBy.username',
                    'updated_at',
                   'createdBy.username',
                ],
            ])
            ?>

        </div>
    </div>
</div>