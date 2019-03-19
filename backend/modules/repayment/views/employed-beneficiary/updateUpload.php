<?php

use yii\helpers\Html;
$this->title = 'Update Employee';
?>
<div class="employed-beneficiary-update">
<div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formUpdateEmployee', [
        'model' => $model,'action'=>$action
    ]) ?>

</div>
    </div>
</div>
