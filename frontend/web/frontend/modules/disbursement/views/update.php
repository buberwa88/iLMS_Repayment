<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\disbursement\models\Instalment */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Instalment',
]) . $model->instalment_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Instalments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->instalment_id, 'url' => ['view', 'id' => $model->instalment_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="instalment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
