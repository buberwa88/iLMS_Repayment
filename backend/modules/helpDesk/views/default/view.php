 <?php
 
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
/*
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
 * 
 */

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Help Desk';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appleal-default-index">
    <div class="panel panel-info">
    <div class="panel-heading">  

    <?= Html::encode($this->title) ?>
        <?php if($application_id !=''){ ?>
        <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/preview-application-form','id'=>$application_id])?>"target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-eye"></i> Preview PDF Form</a>
        <?php } ?>
        </div>
        <div class="col-xs-4">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">STUDENT PHOTO</h3>
                </div>   
               <?php
                $attachment_definition_id='3';
                $resultsPath=\backend\modules\application\models\VerificationFrameworkItem::getApplicantAttachmentPath($attachment_definition_id,$application_id);
                if($application_id !=''){
                ?>
               <img class="img" src="<?= '../'.$resultsPath->attachment_path?>" alt="">
               <?php } ?>
          </div>
        </div>
        
        <div class="col-xs-4">
            <div class="box box-primary">
              <div class="box-header">
                    
              </div>     
               <?php $fullname = $model->applicant->user->firstname.' '.$model->applicant->user->middlename.' '.$model->applicant->user->surname;
			   $application_id1=$application_id;
                           $released=$released;
                           $verificationStatus1=$verificationStatus;
			   ?>   
               <p>
                 &nbsp;Full Name:-<b><?= $fullname;?></b><br/>
                 &nbsp;Form IV Index No:- <b><?= $model->applicant->f4indexno;?></b><br/>
                 <br/><br/><br/>
              </p>
          </div>
        </div>
        <div class="col-xs-4">
            <div class="box box-primary">
              <div class="box-header">
              </div>     
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'enableClientValidation' => TRUE, 'action' => ['/report/report/print-report-students'], 'options' => ['method' => 'post','target'=>'_blank']]); ?>
                <?php echo "<div class='form-group'><label class='col-md-3'>" . "PRINTING" . "</label><div class='col-md-9'>"; ?>
                
				<?php
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [ // 2 column layout
                                    'uniqid' => ['type' => Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\select2\Select2::className(),
                                        'label' => false,
                                        'options' => [
                                            'data' => ArrayHelper::map(\backend\modules\report\models\Report::findBySql('SELECT id,name FROM report WHERE student_printview=1')->asArray()->all(), 'id', 'name'),
                                            'options' => [
                                                'prompt' => 'Select',
                                            ],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                        ],
                                    ],
                                ]
                            ]);
                            ?>
				<?= $form->field($model, 'export_mode')->label(false)->dropDownList([ '1' => 'Landscape','2' => 'Portrait'], ['prompt' => 'Select Export Mode']) ?>			
                <?= $form->field($model, 'exportCategory')->label(false)->hiddenInput(['value' => 1, 'readOnly' => 'readOnly']) ?>
                <?= $form->field($model, 'application_id')->label(false)->hiddenInput(['value' => $application_id, 'readOnly' => 'readOnly']) ?>
                <?= $form->field($model, 'pageIdentifyStud')->label(false)->hiddenInput(['value' => 1, 'readOnly' => 'readOnly']) ?>
                <?php echo "</div></div>"; ?>
                <div class="text-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Generate' : 'Generate', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
          </div>
        </div>
          
   
        <div class="panel-body">
            <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                    
              </div>     
               <?php     
   echo $this->render('_search', ['model' => $searchModel,'action'=>'index']); 
   //echo"<pre/>";var_dump($application_id);
   ?>
          </div>
        </div>            
    <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Application Details',
                        'content' => $this->render('application_details', ['model' => $model,'dataProviderApplicantAssociate' =>$dataProviderApplicantAssociate,'searchModelApplicantAssociate'=>$searchModelApplicantAssociate,'dataProviderApplicantAttachment' =>$dataProviderApplicantAttachment,'searchModelApplicantAttachment'=>$searchModelApplicantAttachment,'dataProviderEducation'=>$dataProviderEducation,'searchModeleducation'=>$searchModeleducation,'application_id'=>$application_id]),
                        'active' => ($active == 'atab1') ? true : false,
                    ],                    
                    [
                        'label' => 'Allocation Details',
                        'content' => $this->render('allocation_details', ['model' => $model,'dataProviderAllocatedLoan'=>$dataProviderAllocatedLoan,'searchModelAllocatedLoan'=>$searchModelAllocatedLoan]),
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],
                    [
                        'label' => 'Disbursement Details',
                        'content' => '',
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],                    
                    [
                        'label' => 'Repayment Details',
                        'content' => '',
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],
                    [
                        'label' => 'Appeal',
                        'content' => '',
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],
                    [
                        'label' => 'Complain',
                        'content' => '',
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false
            ]);
            ?>
</div>
  </div>
</div>
    </div>
