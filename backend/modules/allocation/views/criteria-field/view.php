<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaField */

$this->title = "Criteria Field Detail";
$this->params['breadcrumbs'][] = ['label' => 'Criteria Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-field-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'criteria_field_id',
           // 'criteria_id',
            'applicantCategory.applicant_category',
            'source_table',
            'source_table_field',
            'operator',
            'value',
          //  'parent_id',
            'join_operator',
            'academicYear.academic_year',
             'typeName',
             
            'weight_points',
            'priority_points',
        ],
    ]) ?>

</div>
