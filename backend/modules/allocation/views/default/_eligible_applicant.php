 
<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Eligible Application ';
$this->params['breadcrumbs'][] = $this->title;
 
?>

<div class="application-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
        
            <div  id="formId">
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
               [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('application-compliance-view',['model'=>$model]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
            //'application_id',
           // 'applicant_id',
                        
            [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'vAlign' => 'middle',
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'surname',
                         'label'=>"Last Name",
                        'vAlign' => 'middle',
                         
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
                    ],
                    [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'vAlign' => 'middle',
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
                    ],
 
        ],
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
    ]); ?>
</div>
 </div>
</div>
</div>