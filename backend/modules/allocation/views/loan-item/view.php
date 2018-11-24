<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LoanItem */

$this->title = "Loan Item Detail";
$this->params['breadcrumbs'][] = ['label' => 'Loan Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-item-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->loan_item_id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->loan_item_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'loan_item_id',
                    'item_name',
                    'item_code',
                    'day_rate_amount',
                //'is_active',
                ],
            ])
            ?>

        </div>
    </div>
</div>
