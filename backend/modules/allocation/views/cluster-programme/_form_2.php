<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//use wbraganca\dynamicform\DynamicFormWidget;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'academic_year_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cluster_definition_id')->label(FALSE)->hiddenInput(["value" => $model->isNewRecord ? $cluster_id : $model->cluster_definition_id]) ?>

    <?= $form->field($model, 'programme_category_id')->textInput() ?>
    
   <div class="row">
   <div class="panel panel-default">
        <div class="panel-body" style="margin: 0;">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                //'limit' => 1, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $ClusterProgramme[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'programme_group_id',
                ],
            ]); ?>

           
                <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($ClusterProgramme as $i => $ClusterProgramme2): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Programmes List</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                        ?>
                        <?= $form->field($ClusterProgramme2, "[{$i}]programme_group_id")->textInput(['maxlength' => true]) ?>
                        <?= $form->field($ClusterProgramme2, "[{$i}]programme_priority")->textInput(['maxlength' => true]) ?>

                    </div>
                </div>
            <?php endforeach; ?>
            </div>            
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
       </div>
    
    
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
