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

    <?php 
	$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'action' =>'',
        'method' => 'get',]);
	//f4indexno
	?>
  
	<?php echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>3,
    'attributes'=>[ // 2 column layout
    'f4indexno'=>['type'=>Form::INPUT_TEXT,'label'=>'f4indexno'],
    'firstName'=>['type'=>Form::INPUT_TEXT,'label'=>'First Name'],
	'surname'=>['type'=>Form::INPUT_TEXT,'label'=>'Last Name'],
        'f4indexno'=>['type'=>Form::INPUT_TEXT,'label'=>'f4indexno'],
        //'academic_year_id'=>['type'=>Form::INPUT_TEXT,'label'=>'Last Name'],
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where("is_current=1")->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => 'Select Academic Year',
                    'allowClear' => true
                ],
            ],
        ],
        'instititution' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Learning Institution',
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\LearningInstitution::find()->where(["institution_type"=>"UNIVERSITY"])->all(),'learning_institution_id','institution_name'),
                'options' => [
                    'prompt' => 'Select Institution',
                ],
            ],
        ],
        'programme_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme Name',
            'options' => [
                'data' =>ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                'options' => [
                    'prompt' => 'Select Programme Name',
                    'allowClear' => true
                ],
             
            ],
        ],
        'surname'=>['type'=>Form::INPUT_TEXT,'label'=>'Last Name'],
    ]
    ]); ?>
    <div class="text-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>        
         <?=Html::a('Reset', 'index.php?r=allocation/allocation-student/index', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
