<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Disbursed Loan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model){
                  return $this->render('disbursed_loan_item',['model'=>$model,'application_id'=>$model->application_id,'academic_year_id'=>$model->disbursementBatch->academic_year_id,'semester_number'=>$model->disbursementBatch->semester_number,'instalment_definition_id'=>$model->disbursementBatch->instalment_definition_id]); 
                  //return $this->render('index',['model'=>$model]); 
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
              
                    [
                     'attribute' => 'academic_year_id',
                        'label'=>'Academic Year',
                        //'vAlign' => 'middle',
                        //'width' => '120px',
                        'value' => function ($model) {
                            return $model->disbursementBatch->academicYear->academic_year;
                        },
                       'filterType' => GridView::FILTER_SELECT2,
                        //'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                        'filter' =>ArrayHelper::map(\common\models\AcademicYear::findBySql('SELECT academic_year_id,academic_year FROM `academic_year`')->asArray()->all(), 'academic_year_id', 'academic_year'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search  '],
                        'format' => 'raw'
                    ],
                                [
                     'attribute' => 'semester_number',
                        'label'=>'Semister',
                        //'vAlign' => 'middle',
                        //'width' => '120px',
                        'value' => function ($model) {
                            return $model->disbursementBatch->semester_number;
                        },
                       'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>"1",2=>'2'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                                [
                     'attribute' => 'instalment_definition_id',
                        'label'=>'Instalment',
                        //'vAlign' => 'middle',
                        //'width' => '120px',
                        'value' => function ($model) {
                            return $model->disbursementBatch->instalmentDefinition->instalment_desc;
                        },
                       'filterType' => GridView::FILTER_SELECT2,
                        //'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                        'filter' =>ArrayHelper::map(\backend\modules\disbursement\models\InstalmentDefinition::findBySql('SELECT instalment_definition.instalment_definition_id AS "id",instalment_definition.instalment_desc AS "Name" FROM `instalment_definition` INNER JOIN disbursement_batch ON disbursement_batch.instalment_definition_id=instalment_definition.instalment_definition_id INNER JOIN disbursement ON disbursement_batch.disbursement_batch_id=disbursement.disbursement_batch_id WHERE disbursement.application_id="'.$model->application_id.'" AND disbursement_batch.is_approved="1" AND instalment_definition.is_active="1"')->asArray()->all(), 'id', 'Name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search  '],
                        'format' => 'raw'
                    ],
                    [
                'attribute' => 'disbursed_amount',
                'label'=>'Amount',        
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {           
                return \frontend\modules\application\models\Application::getTotalDisbursedLoan($model->application_id,$model->disbursementBatch->academic_year_id,$model->disbursementBatch->semester_number,$model->disbursementBatch->instalment_definition_id);
        },
            ],            
                   
        ],
    ]); ?>
</div>
</div>
</div>
