<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\GepgReconMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Reconciliation';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-recon-master-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">

    <p>
        <?= Html::a('Create New Reconciliation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'recon_master_id',
            'recon_date',
			'description',
            'created_at',
			[
                        'attribute' => 'status',
                        //'vAlign' => 'middle',
                        'label'=>"Status",
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->status==0?"Committed":"Not Committed";
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Committed',1=>'Not Committed'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ], 

            //['class' => 'yii\grid\ActionColumn',
			//'template'=>'{view}',
			//],
        ],
    ]); ?>
    </div>
       </div>
</div>
