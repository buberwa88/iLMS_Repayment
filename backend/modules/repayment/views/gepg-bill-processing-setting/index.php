<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\GepgBillProcessingSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gepg Bill Processing Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-bill-processing-setting-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gepg Bill Processing Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'bill_type',
            'bill_processing_uri',
            'bill_prefix',
            'operation_type',
            // 'created_by',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',

            ],
        ],
    ]); ?>
    </div>
       </div>
</div>
