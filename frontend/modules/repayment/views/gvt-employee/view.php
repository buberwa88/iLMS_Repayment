<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\GvtEmployee */

$this->title = $model->gvt_employee;
$this->params['breadcrumbs'][] = ['label' => 'Gvt Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gvt-employee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->gvt_employee], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->gvt_employee], [
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
            'gvt_employee',
            'vote_number',
            'vote_name',
            'Sub_vote',
            'sub_vote_name',
            'check_number',
            'f4indexno',
            'first_name',
            'middle_name',
            'surname',
            'sex',
            'NIN',
            'employment_date',
            'created_at',
            'payment_date',
        ],
    ]) ?>

</div>
