<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\GvtEmployee */

$this->title = 'Create Gvt Employee';
$this->params['breadcrumbs'][] = ['label' => 'Gvt Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gvt-employee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
