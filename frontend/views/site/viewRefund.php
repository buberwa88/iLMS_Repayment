<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
$this->title = 'View Refund Status';
?>
<div class="password-reset-beneficiary">

    <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php
            echo $this->render('_form_view_refund', [
                'model' => $model,
            ]);
            ?>
        </div>
    </div>
</div>