<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentTransfers */

$this->title = 'Student Transfers Details #' . $model->student_transfer_id;
$this->params['breadcrumbs'][] = ['label' => 'Student Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sector-definition-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?php if ($model->status != backend\modules\allocation\models\StudentTransfers::STATUS_COMPLETED): ?>
                    <?= Html::a('Update', ['update', 'id' => $model->student_transfer_id], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a('Delete', ['delete', 'id' => $model->student_transfer_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                <?php endif; ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'student_f4indexno', 'student_reg_no',
                    [
                        'attribute' => 'academic_year_id',
                        'value' => $model->academicYear->academic_year
                    ], [
                        'attribute' => 'academic_year_id',
                        'value' => $model->academicYear->academic_year
                    ], [
                        'attribute' => 'programme_from',
                        'value' => $model->programmeFrom->programme_name
                    ],
                    [
                        'attribute' => 'programme_to',
                        'header' => 'Previous Programme',
                        'value' => $model->programmeTo->programme_name
                    ],
                    'date_initiated',
                    [
                        'attribute' => 'status',
                        'value' => $model->getStatusName()
                    ],
                ],
            ])
            ?>
        </div></div>
</div>
