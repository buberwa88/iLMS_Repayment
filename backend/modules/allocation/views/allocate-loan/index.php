<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

$this->title = "Allocate Loan ";
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alloca'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                        'label' => 'Allocate Freshers Student\'s Loan',
                        'content' => $this->render('_form_allocate_freshers', [
                            'model' => $model,
                        ]),
                        'id' => 'tab1',
                    ],
                    [
                        'label' => 'Allocate Continuing Student\'s Loan',
                        'content' => $this->render('_form_allocate_continuing', [
                            'model' => $model,
                        ]), 'id' => 'tab2',
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