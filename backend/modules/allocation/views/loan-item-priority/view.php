<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LoanItemPriority */

$this->title = 'Loan Item Priority #' . $model->loan_item_priority_id;
$this->params['breadcrumbs'][] = ['label' => 'Loan Item Priorities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-item-priority-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->loan_item_priority_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->loan_item_priority_id], [
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
            'loan_item_priority_id',
            'academic_year_id',
            'loan_item_id',
            'priority_order',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ])
    ?>

</div>
