<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Programme */

//$this->title = "Higher Learning Institution Programme Detail";
$this->params['breadcrumbs'][] = ['label' => 'Programme', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-view">
    <div class="panel panel-info">
        <div class="panel-body">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->programme_id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->programme_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>

                <?= Html::a('Add Programme Cost', ['/allocation/programme/cost', 'id' => $model->programme_id], ['class' => 'btn btn-success']) ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'programme_name',
                    'programme_code',
                    [
                        'attribute' => 'programme_group_id',
                        'value' => backend\modules\allocation\models\ProgrammeGroup::getGroupNameByID($model->programme_group_id),
                    ],
                    'learningInstitution.institution_name',
                    'years_of_study',
                    [
                        'attribute' => 'is_active',
                        'value' => $model->getStatusNameByValue(),
                    ],
                ],
            ])
            ?>

        </div>
    </div>
</div>