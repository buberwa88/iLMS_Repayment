<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

$this->title = "Award Student Loan ";
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Alloca'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title . ' for Academic Year: ' . $model->academicYear->academic_year) ?>
        </div>
        <div class="panel-body">
            <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Award Loan - Local Freshers Student\'s',
                        'content' => $this->render('_form_allocate_freshers', [
                            'model' => $model,
                        ]),
                        'id' => 'tab1',
                        'active' => ($tab == 'tab1') ? TRUE : FALSE
                    ],
                    [
                        'label' => 'Award Loan - Local Continuing Student\'s',
                        'content' => $this->render('_form_allocate_continuing', [
                            'model' => $model,
                        ]), 'id' => 'tab2',
                        'active' => ($tab == 'tab2') ? TRUE : FALSE
                    ],
                    [
                        'label' => 'Award Loan Grant/Scholarship Student\'s',
                        'content' => $this->render('_form_allocate_grant_scholars', [
                            'model' => $model,
                        ]), 'id' => 'tab3',
                        'active' => ($tab == 'tab3') ? TRUE : FALSE
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