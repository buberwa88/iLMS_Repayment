<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'Employer registration form';
//$this->params['breadcrumbs'][] = ['label' => 'Employers Account Creation', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-create">

<div class="panel panel-info">
        <div class="panel-heading">
  <font size="4">     
Welcome, New user!
<br/>
This registration form is for employers. Please complete the form below for registration into the iLMS.
</font>

        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
       'model1' => $model1,'model2' => $model2,'model3'=>$model3,
    ]) ?>

</div>
    </div>
</div>
