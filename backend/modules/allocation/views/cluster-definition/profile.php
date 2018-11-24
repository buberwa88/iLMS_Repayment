<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */

$this->title = "Cluster Details";
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Cluster Detail',
                        'content' => $this->render('view', ['model' => $model]),
                        'id' => '1',
                    ],
                    [
                        'label' => 'Cluster Programmes ',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/cluster-programme/index', 'id' => $model->cluster_definition_id]) . '" width="100%" height="600px" style="border: 0"></iframe>',
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