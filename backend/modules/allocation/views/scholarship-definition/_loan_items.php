<?php

use backend\modules\allocation\models\ScholarshipDefinition;
?>
<p>
    <?php if ($model->is_active != ScholarshipDefinition::STATUS_INACTIVE) { ?>

        <?= \yii\bootstrap\Html::a('Add Loan Item', ['/allocation/scholarship-definition/add-loan-item', 'id' => $model->scholarship_id], ['class' => 'btn btn-success']) ?>
    <?php } ?>   
    <?=
    \yii\bootstrap\Html::a('Copy Existing', ['/allocation/scholarship-definition/clone-loan-item', 'id' => $model->scholarship_id], ['class' => 'btn btn-warning',
        'data' => [
            'confirm' => 'Are you sure you want to Copy Loan Items from One Academic Year Into another?',
            'method' => 'post',
        ],]
    );
    ?>
</p>
<?=
\kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'loanItem.item_name',
        ['attribute' => 'is_loan_item',
            'value' => function($model) {
                return $model->getScholarShipIteTypeName();
            }
        ], ['attribute' => 'is_active',
            'value' => function($model) {
                return $model->getScholarShipStatusName();
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
?>
