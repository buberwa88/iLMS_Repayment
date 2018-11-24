<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QpossibleResponse $model
 */

$this->title = 'Create Qpossible Response';
$this->params['breadcrumbs'][] = ['label' => 'Qpossible Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qpossible-response-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
