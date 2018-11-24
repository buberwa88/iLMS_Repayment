<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

$this->title = 'Student Exam Results';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-exam-result-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Add/Post Exam Result', ['institution/add-student-exam-result'], ['class' => 'btn btn-success']) ?>    
                <?php echo Html::a('Upload Student Exam Results', ['upload-students-exam-results'], ['class' => 'btn btn-warning']) ?></p>

            <?= Html::beginForm(['student-exam-result/confirm-students-exam'], 'post'); ?>        

            </p>
            <?php
            echo TabsX::widget([
                "id" => "tabs",
                'items' => [
                    [
                        'label' => 'Pending Exam Results',
                        'content' => $this->render('_pending_studexamresult', ['dataProvider' => $pendingExamReslt, 'model' => $model, 'searchModel' => $searchModel]),
                        'linkOptions' => array('id' => 'tab1'),
                        'id' => 'tab1',
                        'active' => TRUE,
                    ], [
                        'label' => 'Verified Exam Results',
                        'content' => $this->render('_verified_studexamresult', ['dataProvider' => $verifiedExamReslt, 'model' => $model, 'searchModel' => $searchModel]),
                        'id' => 'tab2',
                        'linkOptions' => array('id' => 'tab2'),
//                        'active' => ($active == 'tab2') ? TRUE : FALSE,
                    ],
                    [
                        'label' => 'Confirmed Exam Results for HESLB Use',
                        'content' => $this->render('_confirmed_studexamresult', ['dataProvider' => $confirmedExamReslt, 'model' => $model, 'searchModel' => $searchModel]),
                        'id' => 'tab3',
                        'linkOptions' => array('id' => 'tab3'),
//                        'active' => ($active == 'tab3') ? TRUE : FALSE,
                    ],
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false
            ]);
            ?>
        </div>
    </div>
    <!--</div>JS TO SET ACTIVE TAB-->
    <?php
    $this->registerJs("jsfuncs", "
        var active = 'tab1';
        $('#tab1').click(function(){active='tab1'});
        $('#tab2').click(function(){active='tab2'});
        $('#tab3').click(function(){active='tab3'});

      ", yii\web\View::POS_END);
    ?>