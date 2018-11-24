<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'Update Information';
$this->params['breadcrumbs'][] = ['label' => 'My Account', 'url' => ['view','id'=>$model1->employer_id]];
$this->params['breadcrumbs'][] = ['label' => $model1->employer_id, 'url' => ['view', 'id' => $model1->employer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-update">
<div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">


    <?= $this->render('_formUpdateInformation', [
        'model1' => $model1,'model2' => $model2,
    ]) ?>

</div>
    </div>
</div>
