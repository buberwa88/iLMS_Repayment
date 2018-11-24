<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\DatePicker;


/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="applicant-search">

    <?php //$form = ActiveForm::begin([
        //'action' => ['all-loanees'],
        //'method' => 'get',
    //]); 
	$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'action' => ['all-loanees'],
        'method' => 'get',]);
	?>
    <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>2,
    'attributes'=>[ // 2 column layout
    'f4indexno'=>['type'=>Form::INPUT_TEXT,'label'=>'Form IV Indexno'],
	'NID'=>['type'=>Form::INPUT_TEXT,'label'=>'National Identification No.'],
    ]
    ]); ?>
	<?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>3,
    'attributes'=>[ // 2 column layout
    'firstname'=>['type'=>Form::INPUT_TEXT,'label'=>'First Name'],
	'middlename'=>['type'=>Form::INPUT_TEXT,'label'=>'Middle Name'],
	'surname'=>['type'=>Form::INPUT_TEXT,'label'=>'Last Name'],
    ]
    ]); ?>
	<?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>2,
    'attributes'=>[ // 2 column layout
    'academic_year_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Academic Year',
                'options' => [
                    'data' =>ArrayHelper::map(common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                    'options' => [
                        'prompt' => 'Select Academic Year',
                    ],
                    'pluginOptions' => [
                    'allowClear' => true
                    ],
                ],
            ],
	'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution',
                'options' => [
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => 'Select Learning Institution',
						//'allowClear'=>true,
                    ],
                    'pluginOptions' => [
                    'allowClear' => true
                    ],
                ],
            ],
			/*
		'date_of_birth'=>[
     'type'=>Form::INPUT_WIDGET,
     'widgetClass'=>'\kartik\widgets\DatePicker',
     'pluginOptions' => [
     'autoclose' => true,
     'format' => 'yyyy-mm-dd',
     ]
    ],
	*/	 

    ]
    ]); ?>
	
	<?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(), [
           'name' => 'date_of_birth', 	
    'options' => ['placeholder' => 'Enter birthday (yyyy-mm-dd)',
                  'todayHighlight' => false,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => false,
    ],
]);
?>
<?= $form->field($model, 'check_search')->label(false)->hiddenInput(['value' => 'CheckSearch', 'readOnly' => 'readOnly']) ?>	

    <div class="text-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
