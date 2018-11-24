<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;

$this->title = 'Recover Password';
$this->params['breadcrumbs'][] = "Recover Password";
?>
<center>				
				<ul><?= Html::a('Recover Password- Employer', ['/repayment/default/password-reset-employer']) ?></ul>
				<ul><?= Html::a('Recover Password - Loan Beneficiary', ['/repayment/default/password-reset-beneficiary']) ?></ul>
</center>
      
