<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundContactPerson */

$this->title = 'Update Refund Contact Person: ' . $model->refund_contact_person_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Contact People', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_contact_person_id, 'url' => ['view', 'id' => $model->refund_contact_person_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-contact-person-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
