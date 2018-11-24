<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\EmployerTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employer Types';
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="employer-type-index">
<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employer Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],            
            'employer_type',
			[
                        'attribute' => 'has_TIN',
                        'vAlign' => 'middle',
                        'label'=>"Has TIN?",
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->has_TIN==1?"Yes":"No";
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1=>'Yes',0=>'No'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ],
			[
                        'attribute' => 'is_active',
                        'vAlign' => 'middle',
                        'label'=>"Status",
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->is_active==0?"Inative":"Active";
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [1=>'Active',0=>'Inactive'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
            ], 
			
			['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{update}',
                         'buttons' => [
             'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
				'title' => Yii::t('app', 'update'),
                ]);
            },
          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'update') {
                $url ='index.php?r=repayment/employer-type/update&id='.$model->employer_type_id;
                return $url;
            }
          }
			],
        ],
    ]); ?>
    </div>
       </div>
</div>
