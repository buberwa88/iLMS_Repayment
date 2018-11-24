<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QpossibleResponseSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="qpossible-response-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'qpossible_response_id') ?>

    <?= $form->field($model, 'question_id') ?>

    <?= $form->field($model, 'qresponse_list_id') ?>

    <?= $form->field($model, 'attachment_definition_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
