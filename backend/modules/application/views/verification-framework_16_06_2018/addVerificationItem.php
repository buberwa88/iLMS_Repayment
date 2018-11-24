<?php

use yii\helpers\Html;


$this->title = 'Confgure Verification Item';
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
            $this->render('_form_verification_item', [
                'model' => $model, 'verification_item' => $verification_item,'verification_framework_id'=>$verification_framework_id,
            ])
            ?>

        </div>
    </div>
</div>
