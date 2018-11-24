<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
 

//$name = Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surname . " (" . Yii::$app->user->identity->username . ")";
$this->title = 'Change Your Password';
//$this->title = 'Hi, ' . $name . '';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
         <?= Html::encode($this->title) ?> 
        </div>
        <div class="panel-body">
    
<div style="padding-right:20px; padding-left: 20px;">
    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL,]);
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
 

            'newpass' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => 'Enter new password...', 'minlength' => 6]],
            'repeatnewpass' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => ' Repeat new password...', 'minlength' => 6]],
        ]
    ]);

//    echo Html::submitButton(Yii::t('app', 'Change'), ['class' => 'btn btn-primary pull-left']);
//    ActiveForm::end(); 
    ?>
<?php if (Yii::$app->session->hasFlash('errorMessage')): ?>
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
            <h5><i class="icon fa fa-check"></i>Error!</h5>
        <?= \Yii::$app->session->getFlash('errorMessage'); ?>
        </div>
    <?php
    endif;
    echo Html::submitButton(Yii::t('app', 'Change'), ['class' => 'btn btn-primary pull-left']);
    ActiveForm::end();
    ?>



</div>

</div>
      </div>
</div>

