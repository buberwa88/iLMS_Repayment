<script>
    function setType(type) {
        $('#create-button-id').attr('style', 'display: block');
        if (type == 'P') {
            //Show
            $('#w2').attr('style', 'display: block');
            $('#w3').attr('style', 'display: block');
            $('#w4').attr('style', 'display: block');
            //Hide
            $('#w1').attr('style', 'display: none');
            
        }

        if (type == 'G') {
            //Show
            $('#w1').attr('style', 'display: block');
            $('#w4').attr('style', 'display: block');
            //Hide
            $('#w2').attr('style', 'display: none');
            $('#w3').attr('style', 'display: none');

        }
    }
</script>

<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guarantor $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="guarantor-form">
    <?php
    $gchecked = '';
    $pchecked = '';
    if ($model->type == 'G') {
        $gchecked = "checked='checked'";
        echo '<style>
        #w2, #w3{
            display: none;
        }
    </style>';
    } else if ($model->type == 'P') {
        $pchecked = "checked='checked'";
        echo '<style>
        #w1{
            display: none;
        }
    </style>';
    } else {

        echo '<style>
        #w1, #w2, #w3, #w4, #create-button-id{
            display: none;
        }
    </style>';
    }
    ?>
<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_VERTICAL,
    'enableClientValidation'=> false,
    'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
    <center>  
        <label class="radio-inline"><input type="radio" name="Guarantor[type]" onclick="setType('P')" value="P" <?php echo $pchecked; ?> >Guarantor is an Individual</label>
        <label class="radio-inline"><input type="radio" name="Guarantor[type]" onclick="setType('G')" value="G" <?php echo $gchecked; ?> >Guarantor is an Organization</label>
    </center>
    <br>


    <?php
//    echo Form::widget([
//
//        'model' => $model,
//        'form' => $form,
//        'columns' => 1,
//        'attributes' => [
//           //'type' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => ['P' => 'Person', 'G' => 'Organization'], 'options' => ['prompt' => '']],
//           'type' => ['type' => Form::INPUT_RADIO_BUTTON_GROUP, 'items' => ['P' => 'Person', 'G' => 'Organization'], 'options' => ['prompt' => '']],
//                ]
//    ]);
//    


    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'organization_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Organization Name...', 'maxlength' => 100]],
        ]
    ]);

    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [


            'firstname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Firstname...', 'maxlength' => 45]],
            'middlename' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Middlename...', 'maxlength' => 45]],
            'surname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Surname...', 'maxlength' => 45]],
            'sex' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => ['M' => 'M', 'F' => 'F'], 'options' => ['prompt' => '']],
            //'NID' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Nid...', 'maxlength' => 30]],
            //'passport_photo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Passport Photo...', 'maxlength' => 200]],
            //'occupation_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Occupation::find()->all(), 'occupation_id', 'occupation_desc'), 'options' => ['prompt' => '']],
            //'relationship_type_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(frontend\modules\application\models\RelationshipType::find()->all(), 'relationship_type_id', 'relationship_type'), 'options' => ['prompt' => '']],
        ]
    ]);
    
        echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [

            'occupation_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Occupation::find()->all(), 'occupation_id', 'occupation_desc'), 'options' => ['prompt' => '']],
            'relationship_type_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(frontend\modules\application\models\RelationshipType::find()->all(), 'relationship_type_id', 'relationship_type'), 'options' => ['prompt' => '']],
            'passport_photo' => ['type' => Form::INPUT_FILE, 'options' => ['placeholder' => 'Enter Passport Photo...', 'maxlength' => 200]],
        ]
    ]);



    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [

            'email_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Email Address...', 'maxlength' => 100]],
            'postal_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Postal Address...', 'maxlength' => 30]],
            'physical_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Physical Address...', 'maxlength' => 100]],
            'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Phone Number...', 'maxlength' => 50]],
        ]
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add Guarantor') : Yii::t('app', 'Update Guarantor'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'create-button-id']
    );
    ActiveForm::end();
    ?>

</div>
