<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
?>
<div class="password-rest-category">

<div class="panel panel-info">
        <div class="panel-heading">
        </div>
        <div class="panel-body">

    <?= $this->render('_formPasswordResetCategory', [
       'model' => $model,
    ]) ?>

</div>
    </div>
</div>