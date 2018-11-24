<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
//get learning institution name
$model->learning_institution_id = $model->isNewRecord ? "" : $model->programme->learning_institution_id;
//end
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'academic_year_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Academic  Year',
            'options' => [
                'data' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['is_current' => 1])->asArray()->all(), 'academic_year_id', 'academic_year'),
            ],
        ],
    ]
]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Learning Institution',
            'options' => [
                'data' =>ArrayHelper::map(\backend\modules\allocation\models\LearningInstitution::getHigherLearningInstitution(), 'learning_institution_id', 'institution_name'),
                'options' => [
                    'prompt' => 'Learning Institution',
                    'id' => 'learning_institution_id'
                ],
            ],
        ],
        'programme_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Programme',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->where(["learning_institution_id" => $model->learning_institution_id,'is_active'=>  \backend\modules\allocation\models\Programme::STATUS_ACTIVE])->asArray()->all(), 'programme_id', 'programme_name'),
                'pluginOptions' => [
                    'depends' => ['learning_institution_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/allocation/programme-fee/getprogrammename']),
                ],
                'options' => [
                    'prompt' => 'Programme',
                ],
            ],
        ],
    ]
]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'loan_item_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Loan Item',
            'options' => [
                'data' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->asArray()->all(), 'loan_item_id', 'item_name'),
                'options' => [
                    'prompt' => 'Loan Item',
                    'onchange' => 'updateStatus()'
                ],
            ],
        ],
    ]
]);
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'amount' => ['label' => 'Amount', 'options' => ['placeholder' => 'Amount']],
    ]
]);
?>
<div id="programmefee-days" style="display:none">
<?php
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'days' => ['label' => 'Days', 'options' => ['placeholder' => 'Days']],
    ]
]);
?>
</div>
    <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'year_of_study' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Year Of Study',
                'options' => [
                    'data' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                    'options' => [
                        'prompt' => 'Year Of Study',
                    ],
                ],
            ],
        ],
    ]);
    ?>
<div class="text-right">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

<?php
echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
?>
<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
<?php
ActiveForm::end();
?>
</div>


<script type="text/javascript">

    /********************  
     * Id can be hide or show
     * 
     *onload functions
     ********************/
    window.onload = start;
    function start() {
        //alert("mickidadi");
        updateStatus();

    }
    function updateStatus() {

        var loan_item_value = document.getElementById('programmefee-loan_item_id').value;
        $.ajax({
            type: 'GET',
            url: "<?= \Yii::$app->getUrlManager()->createUrl('/allocation/programme-fee/loan-item'); ?>",
            data: {loan_item_value: loan_item_value},
            success: function (data) {
                // alert(data);
                if (data == 1) {
                    document.getElementById('programmefee-days').style.display = '';
                } else {
                    document.getElementById('programmefee-days').style.display = 'none';
                }

            }


        });
    }
</script>