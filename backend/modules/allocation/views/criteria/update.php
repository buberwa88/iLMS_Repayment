<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Criteria */

$this->title = 'Update Criteria: ';
$this->params['breadcrumbs'][] = ['label' => 'Criterias', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' =>"View Detail", 'url' => ['view', 'id' => $model->criteria_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="criteria-update">
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