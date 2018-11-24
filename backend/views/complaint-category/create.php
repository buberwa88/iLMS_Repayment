<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\ComplaintCategory */

$this->title = 'Create Complaint Category';
$this->params['breadcrumbs'][] = ['label' => 'Complaint Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complaint-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
