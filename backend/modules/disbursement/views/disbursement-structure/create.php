<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementStructure */

$this->title = 'Create Disbursement Structure';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-structure-create">
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
