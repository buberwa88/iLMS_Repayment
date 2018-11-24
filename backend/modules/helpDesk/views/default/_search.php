<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use \backend\modules\application\models\VerificationComment;
use common\models\ApplicantQuestion;


/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantSearch */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php //$form = ActiveForm::begin([
        //'action' => ['all-loanees'],
        //'method' => 'get',
    //]); 
	$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'action' => [$action],
        'method' => 'get',]);
	?>
    <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>4,
    'attributes'=>[ // 2 column layout
    'f4indexno'=>['type'=>Form::INPUT_TEXT,'label'=>'Form IV Indexno'],
	'firstName'=>['type'=>Form::INPUT_TEXT,'label'=>'First Name'],
	'middlename'=>['type'=>Form::INPUT_TEXT,'label'=>'Middle Name'],
	'surname'=>['type'=>Form::INPUT_TEXT,'label'=>'Last Name'], 
    ]
    ]); ?>
	<?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>4,
    'attributes'=>[ // 2 column layout
        'application_form_number'=>['type'=>Form::INPUT_TEXT,'label'=>'Form #'],
	'sex'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Gender',
              
                'options' => [
                    'data' => ['M'=>'Male', 'F'=>'Female'],
                    'options' => [
                        'prompt' => 'Select Gender ',
                   
                    ],
                    'pluginOptions' => [
                                     'allowClear' => true
                                     ],
                ],
             ],
			 'applicant_category' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Category',
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                       'options' => [
                        'prompt' => 'Select Category',
                        
                    ],
                      'pluginOptions' => [
                                     'allowClear' => true
                                     ],
                ],
            ],
    ]
    ]); ?>
	<?= $form->field($model, 'assignee_asi')->label(false)->hiddenInput(['value' => 'CheckSearch', 'readOnly' => 'readOnly']) ?>
    <?php
/*
	echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[    
        'verification_comment' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Verification Comment',
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\application\models\VerificationCommentGroup::findBySql('SELECT  verification_comment_group_id,comment_group FROM `verification_comment_group`')->asArray()->all(), 'verification_comment_group_id', 'comment_group'),
                       'options' => [
                        'prompt' => 'Select Comment',
                        
                    ],
                ],
            ],
			
			'attachment_status' => [
                'label'=>'Attachment Status',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ApplicantQuestion::getVerificationStatus(), 
                'options' => ['prompt' => '-- Select --'],
              ],
			 
    ]
    ]); 
	 */
	?>
    <div class="text-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>        
         <?=Html::a('Reset', [$action], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>


