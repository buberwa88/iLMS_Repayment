<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;
use yii\helpers\Url;

$this->title = 'Waiting Verified Report'
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
            <?php  echo $this->render('_search_application_verification_report', ['model' => $searchModel,'action'=>'waiting-applicationverified-report']); ?>
            <?php  $searchReports=$this->render('_search_verification_report_print', ['searchModel' => $searchModel]);
                   $searchReportsC=$this->render('_search_verification_report_criteria', ['searchModel' => $searchModel]);
                  $searchReportsCexcel=$this->render('_search_verification_report_criteria_excel', ['searchModel' => $searchModel]);
                 ?>
            <br/><br/>
            <div class="text-right">
                <?php 
                $verification_status2 =3;
echo Html::a('Export PDF&nbsp;&nbsp;&nbsp;&nbsp;&nbsp', Url::toRoute(['verification-print-reportpdf', 'searches' =>$searchReports,'verification_status'=>$verification_status2,'criteriaSearchV'=>$searchReportsC]),
                ['target' => '_blank']);
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; echo Html::a('Export Excel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp', Url::toRoute(['verification-print-reportexcel', 'searches' =>$searchReports,'verification_status'=>$verification_status2,'criteriaSearchV'=>$searchReportsCexcel]));
                ?>
                </div>
<?php
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
[
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) use($fullname,$application_id1){
                  return $this->render('verification_comments',['model'=>$model]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
    [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        //'width' => '200px',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
    ],
    [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
    ],
    [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
                    ],
                    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
                    ],

                     [
                     'attribute' => 'sex',
                        'label'=>"Sex",
                        'value' => function ($model) {
                            return $model->applicant->sex;
                        },
                    ],

                    [
                     'attribute' => 'applicant_category',
                        'label'=>"Category",
                        'value' => function ($model) {
                            return $model->applicantCategory->applicant_category;
                        },
                    ],
                    [
                     'attribute' => 'date_verified2',
                        'label'=>"Date Verified",
                        'format' => 'raw',
                        'value' => function ($model) {
                            if(!empty($model->date_verifie) || $model->date_verified !=''){
                             return date("Y-m-d",strtotime($model->date_verified));   
                            }else{
                             return '';    
                            }
                            
                        },
                    ],
                    [
                     'attribute' => 'officer',
                     'label'=>'Officer',
                        'value' => function ($model) {
                                   
                                     return $model->assignee0->firstname." ".$model->assignee0->middlename." ".$model->assignee0->surname;
                                    
                        },                               
                    ],            
                                               
];
echo GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
    'pjax' => true,
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
    'hover' => true,
    'floatHeader' => true,
    'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
    'showPageSummary' => false,
   /*
    'panel' => [
        'type' => GridView::TYPE_PRIMARY
    ],
*/
]);
?>
</div>
</div>
</div>
