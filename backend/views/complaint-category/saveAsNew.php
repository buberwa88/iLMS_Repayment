<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title = 'Save As New Complaint Category: '. ' ' . $model->complaint_category_id;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->complaint_category_id, 'url' => ['view', 'id' => $model->complaint_category_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="complaint-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
