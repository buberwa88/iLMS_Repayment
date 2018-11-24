<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ProgrammeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Programme Groups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programme-group-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Programme Group', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'programme_group_id',
                    'group_name',
                    'group_code',
                    [
                        'attribute' => 'study_level',
//                        'label'=>'Level of Study',
                        'value' => function($model) {
                            return $model->applicantCategory->applicant_category;
                        },
                    ],
                    [
                        'attribute' => 'is_active',
                        'value' => function($model) {
                            return $model->getStatusNameByValue();
                        },
                    ],
                    //'created_at',
                    //  'created_by',
                    // 'updated_at',
                    // 'updated_by',
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}{delete}'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
