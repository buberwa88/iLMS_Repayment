<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use backend\modules\application\models\VerificationFramework;
use backend\modules\application\models\VerificationFrameworkItem;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use kartik\widgets\Select2
 


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="application-index">
<div class="panel panel-info">
        <div class="panel-heading">         
            <?php //echo Html::encode($this->title) ?>
            Loan Item
        </div>
        <div class="panel-body">

     <?php
	$results=\backend\modules\allocation\models\Allocation::find()->where("application_id = {$model->application_id} AND academic_year_id={$model->academic_year_id} AND is_canceled='0'")->all();
        ?>
            <table><tr><th <?php echo "style=width:20%";?>>Item</th><th <?php echo "style=width:20%";?>>Amount</th></tr>
        <?php   
        foreach ($results AS $loanItem){
            ?>
                <tr><td <?php echo "style=width:20%";?>><?php echo $loanItem->loanItem->item_name; ?></td><td <?php echo "style=width:20%";?>><?php echo number_format($loanItem->allocated_amount); ?></td></tr>
                <?php
        }		 
      ?> 
            <tr></tr></table>
</div>
</div>
    </div>
