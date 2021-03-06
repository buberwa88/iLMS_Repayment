<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
?>
<br/>
<?php
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,]);
?>
<div class="employed-beneficiary-form">
<div class="col-sm-8">
<div class="profile-user-info profile-user-info-striped">
<?php 
$loggedin = Yii::$app->user->identity->user_id;
$employer2 = \frontend\modules\repayment\models\EmployerSearch::getEmployer($loggedin);
$employerID = $employer2->employer_id;
$employerDetails=\frontend\modules\repayment\models\Employer::findOne(['employer_id'=>$employerID]);
?>
<div class="profile-info-row">		
<div class="profile-info-name">
          <label>Employees File:</label>
        </div>
		<div class="profile-info-value">
    <div class="col-sm-12">
    <?php				
echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'employeesFile'=>['type' => Form::INPUT_FILE,
		 'label' => false,
            ],
        ],
]);
?>
</div>
    </div>
</div>	
<div class="profile-info-row">	
<div class="profile-info-name">
          <label>Traced By:</label>
        </div>
		<div class="profile-info-value">
    <div class="col-sm-12">
    <?php				
echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'traced_by' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Traced By:',
                  'options' => [
                      //'data' => ArrayHelper::map(\common\models\User::find()->where(['login_type' => 5])->all(), 'user_id', 'firstname'),
                      
                      'data' =>ArrayHelper::map(\common\models\User::findBySql('SELECT user.user_id,CONCAT(user.firstname," ",user.surname) AS "Name" FROM `user` WHERE user.login_type=5')->asArray()->all(), 'user_id', 'Name'),
                      
                       'options' => [
                        'prompt' => 'Select',                        
                    ],
					'pluginOptions' => [
                        'allowClear' => true
                        ],
                ],
				'label' => false,
            ],
        ],
]);
?>
</div>
    </div>
        </div>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Upload' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['add-uploademployee'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
</div>
</div>
    </div>
	</div>
    