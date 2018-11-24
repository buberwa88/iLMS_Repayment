<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipProgrammeLoanItem */

$this->title = 'Create Scholarship Programme Loan Item';
$this->params['breadcrumbs'][] = ['label' => 'Scholarship Programme Loan Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scholarship-programme-loan-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
