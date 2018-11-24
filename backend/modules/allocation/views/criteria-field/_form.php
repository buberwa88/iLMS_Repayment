<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Html;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'fork']);
$tableall = \yii::$app->db->schema->getTableNames();
$source_table = array();
foreach ($tableall as $tablealls => $value) {
    $source_table[$value] = $value;
}
$source_table_column = array();
if ($model->source_table != "") {
    $tablecolumn = \yii::$app->db->getTableSchema($model->source_table)->getColumnNames();
    if (count($tablecolumn) > 0) {
        foreach ($tablecolumn as $value) {
            $source_table_column[$value] = $value;
        }
    }
}
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'type' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Context or Type',
            'options' => [
                'data' => backend\modules\allocation\models\CriteriaField::getCriteriaFieldTypes(),
                'options' => [
                    'prompt' => '--select--',
                ],
            ],
        ],
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'applicant_category_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Applicant Category',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->asArray()->all(), 'applicant_category_id', 'applicant_category'),
                'options' => [
                    'prompt' => 'Select Applicant Category',
                ],
            ],
        ],
        'source_table' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Source Table',
            'options' => [
                'data' => \backend\modules\allocation\models\CriteriaField::getCriteriaFieldSourceTables(),
                'options' => [
                    'prompt' => 'Select Source Table',
                    'id' => 'source-table_field_Id'
                ],
            ],
        ],
        'source_table_field' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Response Value',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => $source_table_column,
                //'disabled' => $model->isNewrecord ? false : true,
                'pluginOptions' => [
                    'depends' => ['source-table_field_Id'],
                    'placeholder' => 'All Source Table Field',
                    'url' => Url::to(['/allocation/criteria/gettable-column-name']),
                ],
            ],
        ],
        'value' => ['label' => 'Value', 'options' => ['placeholder' => 'Enter Value']],
        'operator' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Operator',
            'options' => [
                'data' => [ '=' => '=', '>' => '>', '>=' => '>=', '<' => '<', '<=' => '<='],
                'options' => [
                    'prompt' => 'Operator',
                ],
            ],
        ],
        'parent_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Parent Cretaria ',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\CriteriaField::find()->where(["criteria_id" => $model->isNewRecord ? $criteria_id : $model->criteria_id])->all(), 'criteria_field_id', function ($model, $defaultValue) {
                    return "Table Name : " . $model->source_table . " Column Name : " . $model->source_table_field . " value : " . $model->value;
                }),
                'options' => [
                    'prompt' => 'Select Parent Cretaria',
                //'id'=>'source-table_Id'
                ],
            ],
        ],
        'join_operator' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Join Operator',
            'options' => [
                'data' => [ 'AND' => 'AND', 'OR' => 'OR'],
                'options' => [
                    'prompt' => 'Select Join Operator',
                // 'id'=>'source-table_Id'
                ],
            ],
        ],
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic  Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['IN', 'is_current', [\backend\modules\allocation\models\AcademicYear::IS_CURRENT_YEAR, \backend\modules\allocation\models\AcademicYear::IS_NOT_CURRENT_YEAR]])->orderBy('academic_year')->asArray()->all(), 'academic_year_id', 'academic_year'),
                // 'data' => ArrayHelper::map(\backend\modules\allocation\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                'options' => [
                    'prompt' => 'Academic  Year',
                ],
            ],
        ],
        'weight_points' => ['label' => 'Weight Points', 'options' => ['placeholder' => 'Weight Points']],
        'priority_points' => ['label' => 'Priority Points', 'options' => ['placeholder' => 'Priority Points']],
    ]
]);
?>
<?= $form->field($model, 'criteria_id')->label(FALSE)->hiddenInput(['value' => $model->isNewRecord ? $criteria_id : $model->criteria_id]) ?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['index', 'id' => $model->isNewRecord ? $criteria_id : $model->criteria_id], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>

