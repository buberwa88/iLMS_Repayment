<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;
/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title ="Applicant  Details";
 
?>
<div class="fixedassets-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
           
<?php

$details= $this->render('view', [
                                'model' => $model,
                                'modelApplicant' => $modelApplicant,
                               
                            ]);
echo TabsX::widget([
    'items' => [
        [
            'label' => 'Applicant Details',
            'content' =>$details,
            'id' => '1',
        ],
        [
            'label' => 'Password Reset',
            'content' => '<iframe src="' . yii\helpers\Url::to(['/application/user/password-reset', 'id' =>$model->user_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
            'id' => '2',
        ],
    ],
    'position' => TabsX::POS_ABOVE,
    'bordered' => true,
    'encodeLabels' => false
]);
?>
                             </div>
                   
                </div>   
