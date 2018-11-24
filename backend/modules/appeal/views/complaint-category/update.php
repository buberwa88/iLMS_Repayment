<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title = 'Update Complaint Category: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Complaint Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Detail', 'url' => ['view', 'id' => $model->complaint_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complaint-category-update">

  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>