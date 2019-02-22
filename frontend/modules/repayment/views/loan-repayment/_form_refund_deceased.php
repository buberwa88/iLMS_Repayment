<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use frontend\modules\repayment\models\RefundApplication;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
$incomplete=0;
$attemptedApplication=0;
?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-heading">
      <h4><i class="icon fa fa-info"></i>  YOU ARE  APPLYING FOR REFUND AS DECEASED</h4>
        </div>
            <div class="panel-body">
                <p>
                    <?php
                    if($attemptedApplication ==1){
                        ?>
                        <label class="label label-primary"> Overall Status</label>:
                        <?php
                    }
                    ?>
                    <?php
                    if($incomplete !=1 && $attemptedApplication==1){
                        echo '<label class="label label-danger">Incomplete</label>';
                    }
                    else if($incomplete==1 && $attemptedApplication==1){
                        echo '<label class="label label-success">Complete</label>';
                    }
                    ?>
                </p>
                </ul>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 1: Deceased's Form 4 Education ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 2: Deceased's Tertiary Education Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 3: Death Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 4: Court Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 5: Social Fund Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 6: Family Session Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 7: Bank Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 8: Contacts Details ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                <li class="list-group-item"><?= yii\helpers\Html::a("Step 9: Submit ",['/application/education/olevel-view']);?><label class='label  <?= $olevel>0?"label-success":"label-danger";?> pull-right'><span class="glyphicon <?=RefundApplication::getStageChecked("OLEVEL", '90')>0?"glyphicon-check":"glyphicon-remove";?>"></span></label></li>
                </ul>
            </div>
        </div>
</div>
