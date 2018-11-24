<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appeal-category-view">
    <div class="panel panel-info">
        
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        <div class="panel-body">


            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                ],
            ]) ?>

            <p class="pull-right">
                <?= Html::a('Update', ['update', 'id' => $model->appeal_category_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->appeal_category_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
</div>
