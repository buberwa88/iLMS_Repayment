<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use backend\modules\application\models\ApplicantCategorySection;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\SectionQuestion $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="section-question-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'applicant_category_section_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> \yii\helpers\ArrayHelper::map(ApplicantCategorySection::findBySql("select acs.applicant_category_section_id as applicant_category_section_id, c.applicant_category as category from applicant_category_section acs inner join applicant_category c on c.applicant_category_id = acs.applicant_category_id where applicant_category_section_id NOT IN (select applicant_category_section_id from section_question where question_id = {$question_id})")->all(), 'applicant_category_section_id', 'category'), 'options' => ['prompt' => '']],
    
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
