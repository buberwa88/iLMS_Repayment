<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Complaints';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-index">
    <div class="panel panel-info">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            
            <div class="panel-body">
            
                <br>
                <p>
                    <?= Html::a('Create Complaint', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                </p>

            <br/><br/>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'complaint',
                        'contentOptions'=>['style'=>'width: 45%;']
                    ],
                    [
                        'attribute'=>'complaintCategory.complaint_category_name',
                        'label'=>'Category'
                    ],
                    [
                        'attribute'=>'creatorName',
                        'label'=>'Creator'
                    ],
                    [
                        'attribute'=>'statusValue',
                        'label'=>'Stats'
                    ],
                    
                    // 'created_by',
                    // 'updated_by',
                    // 'created_at',
                    // 'updated_at',

                    ['class' => 'yii\grid\ActionColumn', 'buttons' => [
                            'my_button' => function ($url, $model, $key) {
                                return Html::a('My Action', ['my-action', 'id'=>$model->id]);
                            },
                           ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>