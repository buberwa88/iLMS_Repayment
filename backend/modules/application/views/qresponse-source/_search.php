<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QresponseSourceSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="qresponse-source-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'qresponse_source_id') ?>

    <?= $form->field($model, 'source_table') ?>

    <?= $form->field($model, 'source_table_value_field') ?>

    <?= $form->field($model, 'source_table_text_field') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
