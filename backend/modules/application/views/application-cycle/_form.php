
<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use common\models\AcademicYear;
use backend\modules\application\models\ApplicationCycleStatus;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\Question $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="question-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'academic_year_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(AcademicYear::find()->all(), 'academic_year_id', 'academic_year'),  'options' => ['prompt' => '--select year--']],
            'application_cycle_status_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(ApplicationCycleStatus::find()->all(), 'application_cycle_status_id', 'application_cycle_status_name'),  'options' => ['prompt' => '--select status--']],
            'application_status_remark' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Application Status Remarks...', 'maxlength' => 500]],

        ]
    ]);
 
    ?>
<div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
    </div>
</div>
