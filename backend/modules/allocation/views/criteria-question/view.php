<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaQuestion */

$this->title = $model->criteria_question_id;
$this->params['breadcrumbs'][] = ['label' => 'Criteria Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-question-view">
    <?=  DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => [
           // 'criteria_question_id',
          //  'criteria_id',
            //'question.question',
             'operator',
         //   'value',
          //  'parent_id',
            'join_operator',
            'operator',
          //  'academicYear.academic_year',
            'type',
            'weight_points',
            'priority_points',
        ],
    ]) ?>

</div>
