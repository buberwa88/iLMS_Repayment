<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealCategory */

$this->title ='Details';
$this->params['breadcrumbs'][] = ['label' => 'Appeal Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appeal-category-view">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
        <p>
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->appeal_category_id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->appeal_category_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->appeal_category_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
         </p>
<?php 
    $gridColumn = [
        //'appeal_category_id',
        'name',
        'description:ntext',
        //'status',
        [
            'attribute' => 'status',
            'label' => 'Status',
            'value' => function($model){
            if ($model->status)
            {return $model->status==1?'Active':'Inactive';}
            else
            {return NULL;}
            },
           
            ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
</div>
</div>
