<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Complaints Tokens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-index">
    <div class="panel panel-info">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            
            <div class="panel-body">
            
            <?php 
                if(yii::$app->user->can('/appeal/complaints/create-token')) { ?>

                <br>
                <p>
                    <?= Html::a('Create Token', ['create-token'], ['class' => 'btn btn-success pull-right']) ?>
                </p>
            <?php } ?>

            <br/><br/>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'fullName',
                        'label'=>'Category'
                    ],
                    [
                        'attribute'=>'tokenStatus',
                        'label'=>'Status'
                    ],
                    
                    // 'created_by',
                    // 'updated_by',
                    // 'created_at',
                    // 'updated_at',

             

                    ['class' => 'yii\grid\ActionColumn',
                     'template' => '{delete}',
                     'buttons' => [
                            'my_button' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                                    'class' => '',
                                    'data' => [
                                        'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                           ]
                    ],
                ],
            ]); ?>
    </div>
</div>
