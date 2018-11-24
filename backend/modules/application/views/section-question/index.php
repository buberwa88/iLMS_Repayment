<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\application\models\ApplicantCategory;
use backend\modules\application\models\SectionQuestion;
use backend\modules\application\models\ApplicantCategorySection;

?>
<div class="section-question-index">

    <?php  echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'section_question_id',
            //'applicant_category_section_id',
            //'question_id',
            //'attachment_definition_id',
            [
              'label'=>'Applicant Category',
              'value'=>function($model){
                  $appCatSecModel = ApplicantCategorySection::findOne($model->applicant_category_section_id);
                  return ApplicantCategory::findOne($appCatSecModel->applicant_category_id)->applicant_category;
              }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['section-question/view', 'id' => $model->section_question_id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
                        );
                    },
                     'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            Yii::$app->urlManager->createUrl(['application/section-question/delete', 'id' => $model->section_question_id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
                        );
                    }
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        //'floatHeader' => true,

        
    ]);  ?>
    
     <?= $this->render('_form', [
        'model' => $model,
        'question_id' => $question_id,
    ]) ?>

</div>
