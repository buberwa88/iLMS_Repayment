<?php

use yii\helpers\Html;


$this->title = 'Add Custom Criteria(Other)';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <?=
            $this->render('_form_add_custom_criteria', [
                'model' => $model, 'model_custom_criteria' => $model_custom_criteria,'verification_framework_id'=>$verification_framework_id,
            ])
            ?>

        </div>
    </div>
</div>
