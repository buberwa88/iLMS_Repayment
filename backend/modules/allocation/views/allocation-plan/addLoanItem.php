<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipProgramme */

$this->title = 'Configure LoanItem';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <?=
            $this->render('_form_add_loan_item', [
                'model' => $model, 'loan_item' => $loan_item
            ])
            ?>

        </div>
    </div>
</div>
