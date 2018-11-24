<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementStructure */

$this->title = 'Create Disbursement Structure';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-structure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
