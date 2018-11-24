<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\ApplicantAssociate */

$this->title = $model->applicant_associate_id;
$this->params['breadcrumbs'][] = ['label' => 'Applicant Associates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-associate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->applicant_associate_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->applicant_associate_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'applicant_associate_id',
            'application_id',
            'organization_name',
            'firstname',
            'middlename',
            'surname',
            'sex',
            'postal_address',
            'phone_number',
            'physical_address',
            'email_address:email',
            'NID',
            'occupation_id',
            'passport_photo',
            'type',
            'learning_institution_id',
            'ward_id',
        ],
    ]) ?>

</div>
