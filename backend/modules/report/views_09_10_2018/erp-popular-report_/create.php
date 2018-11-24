<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ErpPopularReport */

$this->title = 'Create Erp Popular Report';
$this->params['breadcrumbs'][] = ['label' => 'Erp Popular Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="erp-popular-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
