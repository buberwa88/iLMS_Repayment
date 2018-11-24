<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\StudentTransfersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Transfers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sector-definition-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Student Transfers', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'student_f4indexno', 'student_reg_no',
                    [
                        'attribute' => 'academic_year_id',
                        'value' => 'academicYear.academic_year'
                    ],
                    'programmeFrom.programme_name',
                    'programmeTo.programme_name',
                    'date_initiated',
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            return $model->getStatusName();
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>