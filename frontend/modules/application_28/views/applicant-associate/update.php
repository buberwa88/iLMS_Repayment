<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociate */

$this->title = 'Update Applicant Associate: ' . $model->applicant_associate_id;
$this->params['breadcrumbs'][] = ['label' => 'Applicant Associates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->applicant_associate_id, 'url' => ['view', 'id' => $model->applicant_associate_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="applicant-associate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
