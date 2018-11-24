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

<div class="applicant-search">

    <?php //$form = ActiveForm::begin([
        //'action' => ['all-loanees'],
        //'method' => 'get',
    //]); 
	$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'action' => [$action],
        'method' => 'get',]);
	?>

	
	<div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'assigned_at')->label('Assigned From')->widget(DatePicker::classname(), [
           'name' => 'assigned_at', 	
    'options' => ['placeholder' => 'Enter date (yyyy-mm-dd)',
                  'todayHighlight' => false,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => false,
    ],
]);
?>
       </div>
        <div class="col-md-6">
           <?= $form->field($model, 'assigned_at2')->label('Assigned To')->widget(DatePicker::classname(), [
           'name' => 'assigned_at2', 	
    'options' => ['placeholder' => 'Enter date (yyyy-mm-dd)',
                  'todayHighlight' => false,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => false,
    ],
]);
?>
       </div>
    </div>
	<div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'date_verified')->label('Verified From')->widget(DatePicker::classname(), [
           'name' => 'date_verified', 	
    'options' => ['placeholder' => 'Enter date (yyyy-mm-dd)',
                  'todayHighlight' => false,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => false,
    ],
]);
?>
       </div>
        <div class="col-md-6">
           <?= $form->field($model, 'date_verified2')->label('Verified To')->widget(DatePicker::classname(), [
           'name' => 'date_verified2', 	
    'options' => ['placeholder' => 'Enter date (yyyy-mm-dd)',
                  'todayHighlight' => false,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => false,
    ],
]);
?>
       </div>
    </div>
    <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>4,
    'attributes'=>[ // 2 column layout
    'f4indexno'=>['type'=>Form::INPUT_TEXT,'label'=>'Form IV Indexno'],
	'applicant_category' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Category',
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                       'options' => [
                        'prompt' => 'Select Category',
                        
                    ],
                ],
            ],
        'assignee' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Officer',
                  'options' => [
                      'data' => ArrayHelper::map(\common\models\User::findBySql('SELECT user.user_id,CONCAT(user.firstname," ",user.surname) AS "Name" FROM `user` INNER JOIN application ON application.assignee=user.user_id  WHERE user.login_type=5')->asArray()->all(), 'user_id', 'Name'),
                       'options' => [
                        'prompt' => 'Select Officer',
                        
                    ],
                ],
            ],
        'sex'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Gender',
              
                'options' => [
                    'data' => ['M'=>'Male', 'F'=>'Female'],
                    'options' => [
                        'prompt' => 'Select Gender ',
                   
                    ],
                ],
             ],
    ]
    ]); ?>
	<?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>4,
    'attributes'=>[ // 2 column layout
    'firstName'=>['type'=>Form::INPUT_TEXT,'label'=>'First Name'],
	'middlename'=>['type'=>Form::INPUT_TEXT,'label'=>'Middle Name'],
	'surname'=>['type'=>Form::INPUT_TEXT,'label'=>'Last Name'],
        'verification_status' => [
                'label'=>'Status',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => VerificationComment::getApplicationStatus(), 
                'options' => ['prompt' => '-- Select --'],
              ],
    ]
    ]); ?>
	
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

</div>
