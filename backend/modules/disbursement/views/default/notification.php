<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="List of Notification";
 
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
                        <div class="panel-heading">
                  
                        </div>
                        <div class="panel-body">
           
<?php
//$batchdetails= $this->render('student_bank_account');
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Loanee Details ',
          'content' => '<iframe src="' . yii\helpers\Url::to(['/disbursement/default/student-bank-account/']) . '" width="100%" height="400px" style="border: 0"></iframe>',
            'id' => '1',
        ],
         
        
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>
                             </div>
                   
                </div>   
</div>