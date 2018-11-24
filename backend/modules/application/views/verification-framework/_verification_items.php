<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\allocation\models\ScholarshipDefinition;
?>
<div class="verification-framework-item-index">
    <!--    <h4>Grant / Scholarship Students</h4>-->
    <p>
<?= \yii\bootstrap\Html::a('Add Verification Attachment', ['/application/verification-framework/add-verification-items', 'id' => $model->verification_framework_id], ['class' => 'btn btn-success']) ?>        
    </p>
    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $model_verification_items,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'attachment_desc',            
            'verification_prompt',
            [
                     'attribute' => 'category',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->category ==1){
                                     return "Mandatory";
                                    } else if($model->category==2) {
                                        return "Optional";
                                    }
                        },
                    ],
                      
          [
'class'    => 'yii\grid\ActionColumn',
'template' => '{delete}',
'buttons'  => [
    'delete' => function ($url, $model) {
        $url = Url::to(['verification-framework/delete-verification-item', 'id' => $model->verification_framework_item_id]);
        if($model->checkItemsInApplication($model->verification_framework_id)==0){
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
</div>
