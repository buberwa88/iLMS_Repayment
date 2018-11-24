<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */
$model_year=common\models\AcademicYear::findone(["is_current"=>1]);
//print_r($model_year);
$this->title = Yii::t('app', 'Create Allocation Batch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batch'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-batch-create">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title)."[ Academic Year : ".$model_year->academic_year."]"; ?>
        </div>
        <div class="panel-body">
                    <?=
                    $this->render('_form', [
                        'model' => $model,
                        'modelh' => $modelh,
                        'model_year'=>$model_year
                    ])
                    ?>

        </div>
    </div>
</div>
