<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ExamStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Exam Status';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exam-status-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Exam Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'exam_status_id',
            'status_desc',

            ['class' => 'yii\grid\ActionColumn',
             'template'=>'{update}{delete}'],
        ],
    ]); ?>
</div>
 </div>
</div>
