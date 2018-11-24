<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;

$this->title = 'All Verified Applicants Report';
?>
<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
            <?php  echo $this->render('_search_application_verification_report', ['model' => $searchModel,'action'=>'allverified-applicationverified-report']); ?>
            <br/>
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
                     'attribute' => 'verification_status1',
                      'label'=>"Verification Status",               
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->verification_status ==0){
                                     return "Unvarified";
                                    } else if($model->verification_status==1) {
                                        return "Complete";
                                    }
                                   else if($model->verification_status==2) {
                                        return "Incomplete";
                                    }
                                  else if($model->verification_status==3) {
                                        return "Waiting";
                                    }else if($model->verification_status==4) {
                                        return "Invalid";
                                    }else if($model->verification_status==5) {
                                        return "Pending";
                                    }
                        },
                        'format' => 'raw'
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
    'panel' => [
        'type' => GridView::TYPE_PRIMARY
    ],
]);
?>
</div>
</div>
</div>
