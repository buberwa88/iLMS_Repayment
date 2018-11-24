<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<!--<div class="panel-heading"><h4>Allocation Special Groups </h4></div>-->
<?php //if ($model->allocation_plan_stage != \backend\modules\allocation\models\AllocationPlan::STATUS_CLOSED): ?>
    <p><?php //if ($model->allocation_plan_stage != backend\modules\allocation\models\AllocationPlan::STATUS_CLOSED && !$model->hasStudents()) { ?>

            <?= Html::a('Add Custom Criteria', ['/application/verification-framework/add-custom-criteria', 'id' => $model->verification_framework_id], ['class' => 'btn btn-success']) ?>

        <?php //} ?>
    </p>

<?php //endif; ?>
<?=
kartik\grid\GridView::widget([
    'dataProvider' => $model_verification_custom_criteria,
//    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'criteria_name',
        'applicant_source_table',
        'applicant_souce_column',
        'operator',
        'applicant_source_value',
           
                        [
'class'    => 'yii\grid\ActionColumn',
'template' => '{delete}',
'buttons'  => [
    'delete' => function ($url, $model) {
        $url = Url::to(['verification-framework/delete-custom-criteria', 'id' => $model->verification_custom_criteria_id]);
        if(backend\modules\application\models\VerificationFrameworkItem::checkItemsInApplication($model->verification_framework_id)==0){
        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
            'title'        => 'delete',
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method'  => 'post',
        ]);
    }
    },
]
]
                        
                        
            ],
        ]);
        ?>
