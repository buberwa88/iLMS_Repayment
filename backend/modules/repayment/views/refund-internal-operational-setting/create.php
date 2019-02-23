<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundPaylistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Create Refund Internal Operational Setting';
$this->params['breadcrumbs'][] = ['label' => 'Refund Internal Operational Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-create">

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

