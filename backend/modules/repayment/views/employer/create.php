<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'Employers Account Creation';
//$this->params['breadcrumbs'][] = ['label' => 'Employers Account Creation', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-create">

<div class="panel panel-info">
        <div class="panel-heading">
       
Welcome, New user!
<br/>
This registration form is for employers.Complete the details to get registered to the integrated loan management system.

        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
       'model1' => $model1,'model2' => $model2,'model3'=>$model3,
    ]) ?>

</div>
    </div>
</div>
