<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title = "Complaint";
$this->params['breadcrumbs'][] = ['label' => 'Complaint Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-category-view">
    <div class="panel panel-info">

        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        
        <div class="panel-body">
    
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'complaint_category_name',
                    'statusValue',
                ],
            ]) ?>

            <p class="pull-right">
                <?= Html::a('Update', ['update', 'id' => $model->complaint_category_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->complaint_category_id], [
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
