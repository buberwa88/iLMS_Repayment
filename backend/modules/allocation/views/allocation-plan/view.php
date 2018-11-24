<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

$this->title = 'Allocation Framework';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <!--PLAN DETAILS-->
            <?php
            echo $this->render('_details', ['model' => $model]);
            ?>
            <!--PLAN OTHER SECTIONS-->
            <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Execution Order Settings',
                        'content' => $this->render('_allocation_scenario', ['model' => $model, 'model_scenarios' => $model_scenarios]),
                        'id' => 'atab1',
                        'active' => ($active == 'atab1') ? true : false,
                    ],
                    [
                        'label' => 'Special Groups Settings ',
                        'content' => $this->render('_allocation_special_group', ['model' => $model, 'model_special_group' => $model_special_group]),
                        'id' => 'atab2',
                        'active' => ($active == 'atab2') ? true : false,
                    ], [
                        'label' => 'Clusters Settings ',
                        'content' => $this->render('_clusters', ['model' => $model, 'model_clusters' => $model_clusters]),
                        'id' => 'atab3',
                        'active' => ($active == 'atab3') ? true : false,
                    ],
                    [
                        'label' => 'Student Distribution ',
                        'content' => $this->render('_institutions_type', ['model' => $model, 'model_institutions_type' => $model_institutions_type]),
                        'id' => 'atab4',
                        'active' => ($active == 'atab4') ? true : false,
                    ],                    
                    [
                        'label' => 'Gender Setting ',
                        'content' => $this->render('_gender_setting', ['model' => $model, 'model_gender_item' => $model_gender_item]),
                        'id' => 'atab6',
                        'active' => ($active == 'atab6') ? true : false,
                    ],
                    [
                        'label' => 'Loan Items Setting ',
                        'content' => $this->render('_loan_items', ['model' => $model, 'model_loan_item' => $model_loan_item]),
                        'id' => 'atab5',
                        'active' => ($active == 'atab5') ? true : false,
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