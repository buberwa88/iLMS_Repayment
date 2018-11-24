<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Eligible Applicants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Click to Compute Needness', ['allocation-process/compute-needness'], ['class' => 'btn btn-success']) ?>
    </p>
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
                  return $this->render('application-compute-needness_view',['model'=>$model]);  
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
                      //  'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'lastName',
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
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
                    ],
                     [
                        'attribute' => 'academic_year_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->academicYear->academic_year;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\AcademicYear::find()->where("is_current=1")->asArray()->all(), 'academic_year_id', 'academic_year'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                'needness',
           // 'bill_number',
           // 'control_number',
            // 'receipt_number',
            // 'amount_paid',
            // 'pay_phone_number',
            // 'date_bill_generated',
            // 'date_control_received',
            // 'date_receipt_received',
            // 'programme_id',
            // 'application_study_year',
            // 'current_study_year',
            // 'applicant_category_id',
            // 'bank_account_number',
            // 'bank_account_name',
            // 'bank_id',
            // 'bank_branch_name',
            // 'submitted',
             //'verification_status',
           //  'needness',
            // 'allocation_status',
//                    [
//                        'attribute' => 'allocation_status',
//                        'vAlign' => 'middle',
//                        'width' => '200px',
//                        'value' => function ($model) {
//                                          if($model->allocation_status){
//                                              
//                                          }
//                            return $model->academicYear->academic_year;
//                        },
//                        'filterType' => GridView::FILTER_SELECT2,
//                        'filter' =>[ 1=>'Elligible', 2=>'Not Elligible', 3=>'Allocated', 4=>'Not allocated'],
//                        'filterWidgetOptions' => [
//                            'pluginOptions' => ['allowClear' => true],
//                        ],
//                        'filterInputOptions' => ['placeholder' => 'Search'],
//                        'format' => 'raw'
//                    ],
                
            // 'allocation_comment',
            // 'student_status',
            // 'created_at',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
    ]); ?>
</div>
 </div>
</div>