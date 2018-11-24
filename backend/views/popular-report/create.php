<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\PopularReport */

$this->title = 'Create Popular Report';
$this->params['breadcrumbs'][] = ['label' => 'Popular Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="popular-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
