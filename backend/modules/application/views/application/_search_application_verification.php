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
	$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'action' => [$action],
        'method' => 'get',]);
	?>
    <?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>2,
    'attributes'=>[ // 2 column layout
    'f4indexno'=>['type'=>Form::INPUT_TEXT,'label'=>'Form IV Indexno'],
	'applicant_category_id' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Category',
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                       'options' => [
                        'prompt' => 'Select Category',
                        
                    ],
                ],
            ],
    ]
    ]); ?>
	<?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>3,
    'attributes'=>[ // 2 column layout
    'firstName'=>['type'=>Form::INPUT_TEXT,'label'=>'First Name'],
	'middlename'=>['type'=>Form::INPUT_TEXT,'label'=>'Middle Name'],
	'surname'=>['type'=>Form::INPUT_TEXT,'label'=>'Last Name'],
    ]
    ]); ?>
    <div class="text-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>        
         <?=Html::a('Reset', [$action], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
