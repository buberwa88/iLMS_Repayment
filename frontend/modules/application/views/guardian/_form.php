

<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

?>

<div class="guarantor-form">
<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_VERTICAL,
    'enableClientValidation'=> false,
    'options' => ['enctype' => 'multipart/form-data']
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
                    'passport_photo' => ['type' => Form::INPUT_FILE, 'label'=> $passport_label,    'options' => ['placeholder' => 'Enter Passport Photo...', 'maxlength' => 200]],
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

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add Gurdian') : Yii::t('app', 'Update Guardian'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'create-button-id']
    );
    ActiveForm::end();
    ?>

</div>
