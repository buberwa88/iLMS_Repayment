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
      <?php
            echo TabsX::widget([
                'items' => [
                    [
                        'label' => 'Pending Exam. Results',
                        //'content' => $this->render('_pending_studexamresult', ['dataProvider' => $dataProviderPendingStudExamReslt, 'model' => $model]),
                         'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/student-exam-result/indexpending']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => 'tab1',
                        'active' => ($active == 'tab1') ? TRUE : FALSE,
                    ],
                    [
                        'label' => 'Confirmed Exam. Results',
                        //'content' => $this->render('_confirmed_studexamresult', ['dataProvider' => $dataProviderConfirmedStudExamReslt, 'model' => $model]),
                        'id' => 'tab2',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/student-exam-result/indexconfirm']) . '" width="100%" height="600px" style="border: 0"></iframe>',
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