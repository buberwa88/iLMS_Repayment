<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title ='Complaint Category';
$this->params['breadcrumbs'][] = ['label' => 'Complaint Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-category-view">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
     <p>
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->complaint_category_id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->complaint_category_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->complaint_category_id], [
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
        //'complaint_category_id',
        'complaint_category_name',
        'description:ntext',
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