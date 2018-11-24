<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitutionFee */

$this->title = 'Update School Fee: ';
$this->params['breadcrumbs'][] = ['label' => 'School Fee', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => "View Detail", 'url' => ['view', 'id' => $model->learning_institution_fee_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="learning-institution-fee-update">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
