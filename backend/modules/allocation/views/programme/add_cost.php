<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ProgrammeFee */

$this->title = 'Add Programme Cost';
/*
$this->params['breadcrumbs'][] = ['label' => 'Programme Cost', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title. ': '.$model->programme_name;
 * 
 */
?>
<div class="programme-fee-create">
    <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form_add_cost', [
                'model' => $model, 
                'ProgrammeCost' => $ProgrammeCost,
                'programme_id' => $programme_id, 'cost' => $modelProgrammeLoanItemCost,
//                'category'=>$category
            ])
            ?>

        </div>
    </div>
</div>
