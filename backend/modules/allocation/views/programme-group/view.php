<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeGroup */

$this->title = $model->group_name;
$this->params['breadcrumbs'][] = ['label' => 'Programme Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-group-view">

    <h1>Programme Group: <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->programme_group_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->programme_group_id], [
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
//            'programme_group_id',
            'group_code',
            'group_name',
            'programme_group_desc',
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
//                'format' => 'd-M-Y',
            ],
            'createdBy.username',
            'updated_at',
            'updatedBy.username',
        ],
    ])
    ?>

</div>
