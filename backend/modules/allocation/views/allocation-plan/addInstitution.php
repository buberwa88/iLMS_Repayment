<?php

use yii\helpers\Html;

$this->title = 'Add  Student % Distribution';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-setting-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form_add_institution', [
                'model' => $model, 'institution' => $institution
            ])
            ?>
        </div>
    </div>
</div>
