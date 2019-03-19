<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\NatureOfWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sector';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nature-of-work-index">
<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sector', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'description',

            ['class' => 'yii\grid\ActionColumn',
			'template'=>'{update}{delete}',
			
			],
        ],
    ]); ?>
    </div>
       </div>
</div>
