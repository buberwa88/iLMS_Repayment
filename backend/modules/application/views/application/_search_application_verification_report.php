<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use \backend\modules\application\models\VerificationComment;

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
 <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[ 
/*   
        'verification_comment' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Verification Comment',
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\application\models\VerificationComment::findBySql('SELECT verification_comment_id AS "verification_comment_id",CONCAT(verification_comment_group.comment_group,"-",verification_comment.comment) AS "Name" FROM `verification_comment` LEFT JOIN verification_comment_group ON verification_comment_group.verification_comment_group_id=verification_comment.verification_comment_group_id')->asArray()->all(), 'verification_comment_id', 'Name'),
                       'options' => [
                        'prompt' => 'Select Comment',
                        
                    ],
                ],
            ],
*/
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
    ]
    ]); ?>
    <div class="text-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>        
         <?=Html::a('Reset', [$action], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
