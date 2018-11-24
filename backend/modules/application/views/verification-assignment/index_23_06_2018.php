<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Verifications Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-assignment-index">
<div class="panel panel-info">
    <div class="panel-heading">
       
    </div>
        <div class="panel-body">
    <?php
            echo TabsX::widget([
                'items' => [

                    [
                        'label' => 'Assign',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['verification-assignment/assign-applications']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '2',
                    ],
					[
                        'label' => 'Reverse',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['application/reverseapplication-assigned']) . '" width="100%" height="600px" style="border: 0"></iframe>',
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
</div>
