<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\allocation\models\ScholarshipDefinition;
?>
<div class="scholarship-student-index">
    <!--    <h4>Grant / Scholarship Students</h4>-->
    <p>
        <?php if ($model->allocation_plan_stage == \backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && \backend\modules\allocation\models\AllocationPlanGenderSetting::getAllocationGenderPlanID($model->allocation_plan_id) == '') { ?>

            <?= \yii\bootstrap\Html::a('Add Gender Setting', ['/allocation/allocation-plan/add-gender-setting', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-success']) ?>
        <?php } ?>

        <?php
//        if ($model_gender_item->totalCount && $model->allocation_plan_stage != backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE) {
//
//            \yii\bootstrap\Html::a('Copy Existing Setting Into New Academic Year', ['/allocation/allocation-plan/clone-gender-setting', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning',
//                'data' => [
//                    'confirm' => 'Are you sure you want to Copy Gender Setting from One Academic Year Into another?',
//                    'method' => 'post',
//                ],]
//            );
//        }
        ?>
    </p>
    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $model_gender_item,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'female_percentage',
                'value' => 'female_percentage',
//                'format'=>  Yii::$app->formatter
            ],
            'male_percentage',
            /*
              ['class' => 'yii\grid\ActionColumn',
              'template'=>'{update}{delete}',
              'buttons' => [
              'update' => function ($url, $model) {
              return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
              'title' => Yii::t('app', 'update'),
              ]);
              },
              'delete' => function ($url, $model) {
              return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
              'title' => Yii::t('app', 'delete'),
              ]);
              },
              ],
              'urlCreator' => function ($action, $model, $key, $index) {
              if ($action === 'update') {
              $url = 'index.php?r=allocation/allocation-plan-gender-setting/update&id=' . $model->allocation_plan_gender_setting_id;
              return $url;
              }
              if ($action === 'delete') {
              $url = 'index.php?r=allocation/allocation-plan-gender-setting/delete&id=' . $model->allocation_plan_gender_setting_id;
              return $url;
              }
              }
              ],
             */
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'visible' => ($model->allocation_plan_stage == backend\modules\allocation\models\AllocationPlan::STATUS_INACTIVE && !$model->hasStudents()) ? TRUE : FALSE,
                'buttons' => [
                    /*
                      'view'   => function ($url, $model) {
                      $url = Url::to(['allocation-plan-gender-setting/view', 'id' => $model->allocation_plan_gender_setting_id]);
                      return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'view']);
                      },
                     * 
                     */
                    'update' => function ($url, $model) {
                        $url = Url::to(['allocation-plan/update-gender-plan', 'id' => $model->allocation_plan_gender_setting_id]);
                        return Html::a('<span class="fa fa-pencil"></span>', $url, ['title' => 'update']);
                    },
                            'delete' => function ($url, $model) {
                        $url = Url::to(['allocation-plan/delete-gender-plan', 'id' => $model->allocation_plan_id,'item'=>$model->allocation_plan_gender_setting_id]);
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                                    'title' => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                        ]);
                    },
                        ]
                    ]
                ],
            ]);
            ?>
</div>
