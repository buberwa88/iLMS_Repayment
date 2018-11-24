<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use frontend\modules\application\models\Education;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Application;
use kartik\mpdf\Pdf;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
                        

$this->title ="Appeal Payment";
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<style>
    img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
}



.center {
    margin: auto;
    width: 50%;
    padding: 10px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
<div class="application-view">
    <div class="panel panel-info">
        <div class="panel-heading">
           <?= Html::encode($this->title) ?>
        </div>

    <div class="panel-body">


      
        <?php if($appeal->control_number == null){ ?>
            <?= $this->render("_controll_number") ?>
        <?php } else { ?>
            <?= $this->render("_payment_instruction",['appeal'=>$appeal]) ?>
        <?php } ?>


    </div>
</div>
