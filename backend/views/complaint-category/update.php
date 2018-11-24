<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title = 'Update Complaint Category: ' . ' ' . $model->complaint_category_id;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->complaint_category_id, 'url' => ['view', 'id' => $model->complaint_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complaint-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
