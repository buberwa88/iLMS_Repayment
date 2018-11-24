<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ProgrammeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Institution Programmes List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'programme_id',
              [
                     'attribute' => 'learning_institution_id',
                        'vAlign' => 'middle',
                         
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->learningInstitution->institution_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\application\models\LearningInstitution::find()->where(["institution_type"=>"UNIVERSITY"])->asArray()->all(), 'learning_institution_id', 'institution_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],
            'programme_code',
            'programme_name',
           // 'years_of_study',
            [
                        'attribute' => 'years_of_study',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->years_of_study;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>1,2=>2,3=>3,4=>4,5=>5],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
                        'format' => 'raw'
                    ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
 </div>
</div>