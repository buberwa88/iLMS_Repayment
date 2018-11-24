<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AdmittedStudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admitted Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admitted-student-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Admitted Student', ['createall','id'=>$id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'admitted_student_id',
            'f4indexno',
            'admission_batch_id',
                [
                        'attribute' => 'programme_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->programme->programme_code;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'has_transfered',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                                 $status="";
                                   if($model->has_transfered==0){
                                    $status="No transfer";   
                                   }
                                 else if($model->has_transfered==1){
                                 $status="Transfer Initiated";     
                                 }
                                 else if($model->has_transfered==2){
                                   $status='Transfer Completed' ; 
                                 }
                            return $status;
                             
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[0=>'No transfer', 1=>'Transfer Initiated', 2=>'Transfer Completed'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],

           /*['class' => 'yii\grid\ActionColumn',
             'template' => '{updateall}{deleteall}',
                'buttons' => [
                    'updateall' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil" title="Edit"></span>',
                            $url);
                    },
                      'deleteall' => function ($url,$model,$key) {
                            return Html::a('<span class="green"> <i class="glyphicon glyphicon-trash" title="View"></i></span>', $url);
                    },

                ],
                ],*/
        ],
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
    ]); ?>
</div>
 </div>
</div>
