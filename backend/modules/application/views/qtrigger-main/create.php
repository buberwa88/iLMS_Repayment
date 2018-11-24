<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QtriggerMain $model
 */

$this->title = 'Create Question Trigger';
$this->params['breadcrumbs'][] = ['label' => 'Question Triggers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qtrigger-main-create">
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
