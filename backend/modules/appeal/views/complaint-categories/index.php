<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Complaint Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-category-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
    
    
        <div class="panel-body">

            <p>
                <br/><br/>
                <?= Html::a('Create Complaint Category', ['create'], ['class' => 'btn btn-success pull-right']) ?>
                <br/><br/>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'complaint_category_name',
                    'statusValue',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>