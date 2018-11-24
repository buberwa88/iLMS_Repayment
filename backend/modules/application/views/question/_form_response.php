<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use backend\modules\application\models\QresponseSource;
?>

<form name="foptions">
    <center>  
        <label class="radio-inline"><input type="radio" name="form_name" onclick="setType('TABLE')" value="table" <?php echo $table; ?> >Response from Table</label>
        <label class="radio-inline"><input type="radio" name="form_name" onclick="setType('LIST')" value="list" <?php echo $list; ?> >Response from Defined List</label>
    </center>
</form>
<br><br>
<?php

    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
    echo Form::widget([
        'model' => $modelTable,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'qresponse_source_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(QresponseSource::find()->all(), 'qresponse_source_id', 'source_table'),  'options' => ['prompt' => '']],
                  ]
    ]);
    echo "<center>";
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Update') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    echo "</center>";
    ActiveForm::end();
?>
