<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employed-beneficiary-search">

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
    'columns'=>3,
    'attributes'=>[ // 2 column layout
	'employer_id' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Employer',
                  'options' => [
                      'data' => ArrayHelper::map(\frontend\modules\repayment\models\EmployedBeneficiary::findBySql('SELECT employed_beneficiary.employer_id,employer.employer_name AS "Name" FROM `employed_beneficiary` INNER JOIN employer ON employer.employer_id=employed_beneficiary.employer_id  WHERE employed_beneficiary.verification_status="0" AND employed_beneficiary.applicant_id > "0" AND employed_beneficiary.upload_status="1" GROUP BY employed_beneficiary.employer_id')->asArray()->all(), 'employer_id', 'Name'),
                       'options' => [
                        'prompt' => 'Select Employer',
                        
                    ],
                ],
            ],		
    'firstname'=>['type'=>Form::INPUT_TEXT,'label'=>'First Name'],
	'middlename'=>['type'=>Form::INPUT_TEXT,'label'=>'Middle Name'],
	'surname'=>['type'=>Form::INPUT_TEXT,'label'=>'Last Name'],
	'f4indexno'=>['type'=>Form::INPUT_TEXT,'label'=>'F4indexno'],
    ]
    ]); ?>
    <div class="text-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>        
         <?=Html::a('Reset', [$action], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

