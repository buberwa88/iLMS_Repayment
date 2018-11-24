<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QresponseSource $model
 */

$this->title = 'Update Response Source: ' . ' ' . $model->source_table;
$this->params['breadcrumbs'][] = ['label' => 'Response SOurce', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="qresponse-source-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
