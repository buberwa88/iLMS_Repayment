<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

$this->title = Yii::t('app', 'Create Allocation Batch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-batch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
