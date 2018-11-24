<?php

use yii\helpers\Html;


$this->title = 'Loan beneficiaries registration form';
//$this->params['breadcrumbs'][] = ['label' => 'Employers Account Creation', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-create">

<div class="panel panel-info">
        <div class="panel-heading">
  <font size="4">      
Welcome,User!
<br/>
This registration form is for loan beneficiaries.Please complete the form below for registration into the iLMS.
</font>
        </div>
        <div class="panel-body">


    <?= $this->render('_form', [
        'model' => $model,'model3' => $model3,
    ]) ?>

</div>
    </div>
</div>
