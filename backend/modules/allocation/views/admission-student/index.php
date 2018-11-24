<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AdmittedStudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Admitted Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admitted-student-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Admission Student', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Pending Admission',
                        'content' => $this->render('_pending_admission', ['dataProvider' => $dataProviderPending, 'model' => $model]),
                        'id' => 'tab1',
                        'active' => ($active == 'tab1') ? TRUE : FALSE,
                    ],
                    [
                        'label' => 'Confirmed Admission',
                        'content' => $this->render('_confirmed_admission', ['dataProvider' => $dataProviderConfirmed, 'model' => $model]),
                        'id' => 'tab2',
                        'active' => ($active == 'tab2') ? TRUE : FALSE,
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
