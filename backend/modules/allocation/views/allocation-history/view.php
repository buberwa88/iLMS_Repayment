<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;

$this->title = $model->allocation_name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Allocation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title = 'Allocation Details : ' . $model->allocation_name . ' for:' . $model->academicYear->academic_year) ?>
        </div>
        <div class="panel-body">
            <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Award Details ',
                        'content' => $this->render('_details', ['model' => $model]),
                        'id' => 'atab1',
                        'active' => ($active == 'atab1') ? true : false,
                    ],
                    [
                        'label' => 'Award Student List',
                        'content' => $this->render('_students', ['model' => $model, 'model_students' => $model_students]),
                        'id' => 'atab2',
                        'active' => ($active == 'atab2') ? true : false,
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