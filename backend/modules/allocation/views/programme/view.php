<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title = "Programme Details";
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title . ': ' . $model->programme_name) ?>
        </div>
        <div class="panel-body">

            <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Programme Details',
                        'content' => $this->render('programme_details', ['model' => $model]),
                        'id' => '1',
                    ],
                    [
                        'label' => 'Programme Costs ',
                        //'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/cluster-programme/index', 'id' => $model->cluster_definition_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'content' => $this->render('_programme_costs', ['model' => $programme_costs, 'dataProvider' => $dataProvider]),
                        
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