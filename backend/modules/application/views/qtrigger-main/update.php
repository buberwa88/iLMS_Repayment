<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QtriggerMain $model
 */

$this->title = 'Update Trigger: ';
$this->params['breadcrumbs'][] = ['label' => 'Qn Triggers', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="qtrigger-main-update">

    <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
