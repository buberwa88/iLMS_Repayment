<?php

use yii\helpers\Html;


$this->title = 'Confgure Gender Percentage';
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
            $this->render('_form_gender_setting', [
                'model' => $model, 'gender_item' => $gender_item,'allocation_plan_id'=>$allocation_plan_id,
            ])
            ?>

        </div>
    </div>
</div>
