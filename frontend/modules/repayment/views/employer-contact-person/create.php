<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerContactPerson */

$this->title = 'Create Employer Contact Person';
$this->params['breadcrumbs'][] = ['label' => 'Employer Contact People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-contact-person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
