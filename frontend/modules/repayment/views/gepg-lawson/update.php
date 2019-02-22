<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\GepgLawson */

$this->title = 'Update Gepg Lawson: ' . $model->gepg_lawson_id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Lawsons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gepg_lawson_id, 'url' => ['view', 'id' => $model->gepg_lawson_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gepg-lawson-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
