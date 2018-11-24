<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\Applicant */

$this->title = $model->applicant_id;
$this->params['breadcrumbs'][] = ['label' => 'Applicants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->applicant_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->applicant_id], [
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
            'applicant_id',
            'user_id',
            'NID',
            'f4indexno',
            'f6indexno',
            'mailing_address',
            'date_of_birth',
            'place_of_birth',
            'loan_repayment_bill_requested',
        ],
    ]) ?>

</div>
