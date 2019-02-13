<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */

$this->title ="Refund Application Verification";
//$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Refund', 'url' => Yii::$app->request->referrer];
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
          <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/preview-application-form','id'=>$model->refund_application_id])?>"target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-eye"></i> Preview Form</a>
        </div>


   <div class="panel-body">

    <div class="row" style="margin: 1%;">
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">CLAIMANT  DETAILS</h3>
                </div>
                <?php $fullname = $model->refundClaimant->firstname.' '.$model->refundClaimant->middlename.' '.$model->refundClaimant->surname;
                $application_id1=$application_id;
                $released=$released;
                $verificationStatus1=$verificationStatus;
                ?>
                <p>
                    &nbsp;Full Name:-<b><?= $fullname;?></b><br/>
                    &nbsp;Form IV Index No:- <b><?= $model->refundClaimant->f4indexno;?></b><br/>
                    <br/><br/><br/>
                </p>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="box box-primary">
              <div class="box-header">
                    <h3 class="box-title">CLAIMANT MATCHING STATUS</h3>
              </div>     
               <?php $fullname = $model->refundClaimant->firstname.' '.$model->refundClaimant->middlename.' '.$model->refundClaimant->surname;
			   $application_id1=$application_id;
                           $released=$released;
                           $verificationStatus1=$verificationStatus;
			   ?>   
               <p>
                 &nbsp;F4index #:-<b></b><br/>
                  Claimant Names:-<b></b><br/>
                 &nbsp;Previous Refund Exists:- <b></b><br/>
                 <br/><br/><br/>
              </p>
          </div>
        </div>
        
    </div>
   <div class="row" style="margin: 1%;">
      <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">VERIFY CLAIMANT ATTACHMENTS</h3>
                </div>     
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
             ['class' => 'yii\grid\SerialColumn'],            
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) use($fullname,$application_id1,$released){
                  return $this->render('verification',['model'=>$model,'fullname' => $fullname,'application_id'=>$application_id1,'released'=>$released]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
            ],
             [
                     'attribute' => 'attachment_definition_id',
                        'label'=>"Verification Item",
                        'value' => function ($model) {
                            return $model->attachmentDefinition->attachment_desc;							
                        },
             ],          
             [
                'attribute' => 'verification_status',
                    'value' => function ($model) use($application_id1){
						$resultsPath=\backend\modules\repayment\models\RefundVerificationFrameworkItem::getApplicantAttachmentPath($model->attachment_definition_id,$application_id1);
						
                       if($resultsPath->verification_status == 0){
                            return Html::label("UNVERIFIED", NULL, ['class'=>'label label-default']);
                            } else if($resultsPath->verification_status == 1) {
                            return Html::label("VALID", NULL, ['class'=>'label label-success']);
                            }
                              else if($resultsPath->verification_status == 2) {
                            return Html::label("INVALID", NULL, ['class'=>'label label-danger']);
                            }
                               else if($resultsPath->verification_status == 3) {
                                        return Html::label("WAITING", NULL, ['class'=>'label label-warning']);
                                    }else if($resultsPath->verification_status == 4) {
                                        return Html::label("INCOMPLETE", NULL, ['class'=>'label label-danger']);
                                    }
                        },
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ], 					
             [
               'attribute' => 'comment',
                'label' => 'Verification Status Reason',
				'value' => function ($model) use($application_id1) {
     $resultsPath=\backend\modules\repayment\models\RefundVerificationFrameworkItem::getApplicantAttachmentPath($model->attachment_definition_id,$application_id1);
                            //return $resultsPath->comment;
                           return \backend\modules\repayment\models\RefundComment::getVerificationComment($resultsPath->refund_comment_id);
                 },
             ],
           ],
      ]); ?>
	  <?php if($model->refund_verification_framework_id==''){
		  $checkFrameworkID=0;
		  	  }else{
		   $checkFrameworkID=$model->refund_verification_framework_id;
			  } ?>
                <?php if($released==NULL OR $released==''){ 
				if($model->resubmit=='1'){
				?>
				<a href="<?= Yii::$app->urlManager->createUrl(['/application/application/reattached-applications'])?>" class="btn btn-primary pull-right" style="margin-right: 5px;">Back to the list</a>	
				<?php	
				}else{
				?>
                 <?php $form = ActiveForm::begin(['action' => ['final-submitform','id'=>$model->refund_application_id,'frameworkID'=>$checkFrameworkID]]); ?>
                    <div class="text-right">
                        
        <?= Html::submitButton($model->isNewRecord ? 'Back to the list' : 'Back to the list', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                         <?php ActiveForm::end(); ?>
				<?php }} ?>
    </div>   
</div>
</div>          
</div>
   </div>
</div>
