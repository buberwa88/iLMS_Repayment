<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//$this->title = 'Available Applications';
?>
<div class="row" style="margin: 1%;">        
        <div class="col-xs-12">
            <div class="box box-primary">            
            <?php
         $loggedIn=Yii::$app->user->identity->user_id;
         $todate=date("Y-m-d");
        $todateAttempted=backend\modules\repayment\models\RefundApplicationOperation::getTotalApplicationAttempted($loggedIn,$todate);
        $NotAttempted=backend\modules\repayment\models\RefundApplicationOperation::getTotalApplicationNotAttempted($loggedIn,$todate)
        ?>
            <table class="table table-striped table-bordered detail-view" id="w0" style="font-family: Arial, Helvetica, sans-serif;font-size: 15px;">
                <tbody>
                    <tr>
                        <td>Total Attempted Todate</td>                        
                        <td>Not Attempted</td>                                               
                    </tr>
                    <tr>
                        <td><?php echo number_format($todateAttempted); ?></td>
                        <td><?php echo number_format($NotAttempted); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
