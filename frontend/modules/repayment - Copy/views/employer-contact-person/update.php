<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerContactPerson */

$this->title = 'Update Employer Contact Person: ' . $model->repayment_employer_contact_person_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Contact People', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->repayment_employer_contact_person_id, 'url' => ['view', 'id' => $model->repayment_employer_contact_person_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-contact-person-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
