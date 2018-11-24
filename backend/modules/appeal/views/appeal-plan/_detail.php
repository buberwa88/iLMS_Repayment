<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealPlan */

?>
<div class="appeal-plan-view">

    <div class="row">
        <div class="col-sm-9">
           
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        //'appeal_plan_id',
        [
            'attribute' => 'academicYear.academic_year',
            'label' => 'Academic Year',
        ],
        'appeal_plan_title',
        'appeal_plan_desc',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>