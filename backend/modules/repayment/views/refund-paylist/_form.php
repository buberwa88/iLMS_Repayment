<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use dosamigos\multiselect\MultiSelectListBox;
use yii\web\JsExpression;
?>
<div class="refund-letter-format-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'paylist_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Paylist Name']) ?>
    <?=
    $form->field($model, 'paylist_description')->widget(CKEditor::className(), [
        'options' => ['rows' => 3],
        'preset' => 'advance'
    ])
    ?>
    <p style="margin-top: 2%;margin-bottom: 0;font-size: 16px;"><b>Claimant List</b> <i style="font-size: 13px">( Please select from the Below Claimants Items to include in the Paylist)</i></p>
    <div style="position: relative;float: left;width: 95%;overflow-y: scroll; height: 200px;margin: 0.2%;margin-bottom: 4%;padding-left: 1%; border: 1px solid gray !important">
        <?=
        $form->field($model, 'paylist_claimant')->checkboxList(
                $model->getClaimantsListArray(), ['separator' => '<br>']
        )->label('');
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



