<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
//use kartik\depdrop\DepDrop;
///for tabula form
use kartik\builder\TabularForm;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});
';
$this->registerJs($js);
?>

<?php
//starting thr form
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'dynamic-form']);
//$form = ActiveForm::begin(['id' => 'dynamic-form']);
echo Form::widget([ // fields with labels
    'model' => $model_cost,
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
    ],
]);
?>
<?php
//setting grdis to edit the programme cost based on years of study
echo $this->render('_programme_cost_grid', ['form' => $form, 'model' => $model, 'model_cost' => $model_cost]);
?>



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