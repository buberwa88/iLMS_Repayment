<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\GuarantorSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="guarantor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'guarantor_id') ?>

    <?= $form->field($model, 'application_id') ?>

    <?= $form->field($model, 'organization_name') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'middlename') ?>

    <?php // echo $form->field($model, 'surname') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'postal_address') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'physical_address') ?>

    <?php // echo $form->field($model, 'email_address') ?>

    <?php // echo $form->field($model, 'NID') ?>

    <?php // echo $form->field($model, 'occupation_id') ?>

    <?php // echo $form->field($model, 'passport_photo') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'relationship_type_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
