<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//$this->title = 'Available Applications';
?>
<div class="verification-assignement-index">
    <div class="panel panel-info">        
        <div class="panel-heading">              
        <p>Available Applications </p>
    </div>
        <div class="panel-body">            
            <?php
        $results=backend\modules\application\models\VerificationAssignment::getTotalApplicationByCategory();        
        ?>
            <table class="table table-striped table-bordered detail-view" id="w0" style="font-family: Arial, Helvetica, sans-serif;font-size: 15px;">
                <tbody>
                    <tr>
                        <td>Diploma</td>                        
                        <td>Bachelor</td>                        
                        <td>Masters</td>                        
                        <td>Postgraduate Diploma</td>                        
                        <td>PhD</td>                        
                    </tr>
                    <tr>
                        <td><?php echo number_format($results->Diploma); ?></td>
                        <td><?php echo number_format($results->Bachelor); ?></td>
                        <td><?php echo number_format($results->Masters); ?></td>
                        <td><?php echo number_format($results->Postgraduate_Diploma); ?></td>
                        <td><?php echo number_format($results->PhD); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
