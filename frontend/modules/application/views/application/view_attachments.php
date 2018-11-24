<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */

$this->title ="Attachment List";
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['view-application']];
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => Yii::$app->request->referrer];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
<div class="application-view">
   <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>


   <div class="panel-body">
<div class="row" style="margin: 1%;">        
  <div class="row" style="margin: 1%;">  
      <div class="col-xs-12">    
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
             ['class' => 'yii\grid\SerialColumn'],            
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model){
                  return $this->render('attachment_view',['model'=>$model,'fullname' => $fullname,'application_id'=>$application_id1,'released'=>$released]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
             [
                     'attribute' => 'attachment_definition_id',
                        'label'=>"Attachment",
                        'value' => function ($model) {
                            return $model->attachmentDefinition->attachment_desc;							
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>ArrayHelper::map(\frontend\modules\application\models\ApplicantAttachment::findBySql('SELECT applicant_attachment.attachment_definition_id AS "id",attachment_definition.attachment_desc AS "Name" FROM `applicant_attachment` INNER JOIN attachment_definition ON attachment_definition.attachment_definition_id=applicant_attachment.attachment_definition_id  WHERE applicant_attachment.application_id="'.$model->application_id.'"')->asArray()->all(), 'id', 'Name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search  '],
                        'format' => 'raw'        
             ], 
/*			 
             [
                'attribute' => 'verification_status',
                    'value' => function ($model){
						
                       if($model->verification_status == 0){
                            return Html::label("UNVERIFIED", NULL, ['class'=>'label label-default']);
                            } else if($model->verification_status == 1) {
                            return Html::label("VALID", NULL, ['class'=>'label label-success']);
                            }
                              else if($model->verification_status == 2) {
                            return Html::label("INVALID", NULL, ['class'=>'label label-danger']);
                            }
                               else if($model->verification_status == 3) {
                                        return Html::label("INVALID", NULL, ['class'=>'label label-warning']);
                                    }else if($model->verification_status == 4) {
                                        return Html::label("INCOMPLETE", NULL, ['class'=>'label label-danger']);
                                    }
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[0=>"UNVERIFIED",1=>'VALID',2=>'INVALID',3=>'WAITING',4=>'INCOMPLETE'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],                                 
                         
                         [
                'attribute' => 'comment',
                'label' => 'Verification Status Reason',             
                    'value' => function ($model){
                            if($model->attachmentComment->comment_group==''){
                       return '';         
                            }else{
                       return $model->attachmentComment->comment_group;
                            }
                        },                        
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>ArrayHelper::map(\frontend\modules\application\models\ApplicantAttachment::findBySql('SELECT applicant_attachment.comment AS "id",verification_comment_group.comment_group AS "Name" FROM `applicant_attachment` INNER JOIN verification_comment_group ON verification_comment_group.verification_comment_group_id=applicant_attachment.comment  WHERE applicant_attachment.application_id="'.$model->application_id.'" GROUP BY applicant_attachment.comment')->asArray()->all(), 'id', 'Name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search  '],
                        'format' => 'raw'
                    ],
             */            
           ],
      ]); ?>
</div>          
</div>
   </div>
</div>
