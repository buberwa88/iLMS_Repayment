<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\CriteriaQuestionAnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Criteria Question Answers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criteria-question-answer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Criteria Question Answer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'criteria_question_answer_id',
            'criteria_question_id',
            'qresponse_source_id',
            'response_id',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
