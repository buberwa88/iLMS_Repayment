 
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\LoanItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Loan Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-item-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Sub Cluster Definition', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'sub_cluster_definition_id',
            'sub_cluster_name',
            'sub_cluster_desc',
              
            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{update}{delete}'],
        ],
    ]); ?>
</div>
 </div>
</div>