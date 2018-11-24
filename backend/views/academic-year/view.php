<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AcademicYear */

$this->title = $model->academic_year_id;
$this->params['breadcrumbs'][] = ['label' => 'Academic Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academic-year-view">
    <div class="panel panel-info">
        <div class="panel-heading">
         <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->academic_year_id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->academic_year_id], [
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
                    'academic_year_id',
                    'academic_year',
                    'is_current',
                ],
            ])
            ?>

        </div>
    </div>
</div>