<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Applicant */

$this->title = 'Create Applicant';
$this->params['breadcrumbs'][] = ['label' => 'Applicants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
