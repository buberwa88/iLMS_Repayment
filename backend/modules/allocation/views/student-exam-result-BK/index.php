<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\StudentExamResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
        <?= Html::a('Create Student Exam Result', ['create'], ['class' => 'btn btn-success']) ?>    
    <?php echo Html::a('Upload Bulk Students Exam. Results', ['upload-studentsexam-results'], ['class' => 'btn btn-warning']) ?></p>
        <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Pending Exam. Results',
                        'content' => $this->render('_pending_studexamresult', ['dataProvider' => $dataProviderPendingStudExamReslt, 'model' => $model]),
                        'id' => 'tab1',
                        'active' => ($active == 'tab1') ? TRUE : FALSE,
                    ],
                    [
                        'label' => 'Confirmed Exam. Results',
                        'content' => $this->render('_confirmed_studexamresult', ['dataProvider' => $dataProviderConfirmedStudExamReslt, 'model' => $model]),
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