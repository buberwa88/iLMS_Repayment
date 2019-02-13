<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\NatureOfWork */

$this->title = 'Sector';
$this->params['breadcrumbs'][] = ['label' => 'Sector', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="nature-of-work-create">
 <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

        </div>
    </div>
</div>
