<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitutionFee */

$this->title = 'Create School Fee';
$this->params['breadcrumbs'][] = ['label' => 'School Fees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-fee-create">
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
