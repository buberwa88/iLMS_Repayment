<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title = $model->complaint_category_id;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-category-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Complaint Category'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
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
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'complaint_category_id',
        'complaint_category_name',
        'description:ntext',
        'status',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerComplaint->totalCount){
    $gridColumnComplaint = [
        ['class' => 'yii\grid\SerialColumn'],
            'complaint_id',
                        'complaint:ntext',
            'applicant_id',
            [
                'attribute' => 'complaintParent.complaint',
                'label' => 'Complaint Parent'
            ],
            'complaint_response:ntext',
            'status',
            'level',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerComplaint,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-complaint']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Complaint'),
        ],
        'export' => false,
        'columns' => $gridColumnComplaint
    ]);
}
?>

    </div>
</div>
