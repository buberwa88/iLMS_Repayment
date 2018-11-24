<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'My Account', 'url' => ['view','id'=>$id]];
$this->params['breadcrumbs'][] = ['label' => 'Change Password', 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-change-password">
<div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formChangePassword', [
        'modelUser' => $modelUser,'id'=>$id,
    ]) ?>

</div>
    </div>
</div>
