<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title = 'Save As New Complaint Category: ';
$this->params['breadcrumbs'][] = ['label' => 'Complaint Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Details', 'url' => ['view', 'id' => $model->complaint_category_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="complaint-category-create">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
</div>
</div>