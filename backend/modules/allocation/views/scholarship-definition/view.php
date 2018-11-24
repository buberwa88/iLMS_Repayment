<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

$this->title = "Grant/Scholarship Information";
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php
            echo $this->render('grant_details', ['model' => $model, 'model_study_level' => $model_study_level, 'model_loan_item' => $model_loan_item]);
            ?>
            <div class="" style="position: relative;float: left;width: 46%;margin-left: 2%">

            </div>
            <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Loan Items',
                        'content' => $this->render('_loan_items', ['dataProvider' => $model_loan_item, 'model' => $model]),
                        'id' => 'tab1',
                        'active' => ($active == 'tab1') ? TRUE : FALSE,
                    ],
                    [
                        'label' => 'Eligible Study Levels',
                        'content' => $this->render('_study_level', ['dataProvider' => $model_study_level, 'model' => $model]),
                        'id' => 'tab2',
                        'active' => ($active == 'tab2') ? TRUE : FALSE,
                    ],
                    [
                        'label' => 'Grant Students ',
                        'content' => $this->render('grant_stundents', ['model' => $model, 'model_student' => $model_student]),
                        'id' => 'tab2',
                        'active' => ($active == 'tab3') ? true : false,
                    ],
                    [
                        'label' => 'Learning Institutions ',
                        'content' => $this->render('grant_institutions', ['model' => $model, 'model_learning_institution' => $model_learning_institution]),
                        'id' => 'tab3',
                        'active' => ($active == 'tab4') ? true : false,
                    ],
                    [
                        'label' => 'Eligible Programmes ',
                        'content' => $this->render('grant_programme', ['model' => $model, 'model_programme' => $model_programme]),
                        'id' => 'tab4',
                        'active' => ($active == 'tab5') ? true : false,
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