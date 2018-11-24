<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QpossibleResponse $model
 */

$this->title = 'Update Qpossible Response: ' . ' ' . $model->qpossible_response_id;
$this->params['breadcrumbs'][] = ['label' => 'Qpossible Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->qpossible_response_id, 'url' => ['view', 'id' => $model->qpossible_response_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="qpossible-response-update">

    

    <?= $this->render('_form', [
        'model' => $model,
        'question_id' => $model->question_id,
    ]) ?>

</div>
