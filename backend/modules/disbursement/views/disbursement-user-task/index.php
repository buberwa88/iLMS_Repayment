<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementUserTaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursement Staff Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-user-task-index">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Disbursement Staff Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'disbursement_user_task_id',
            //'disbursement_structure_id',
               [
                        'attribute' => 'disbursement_structure_id',
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->disbursementStructure->structure_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(backend\modules\disbursement\models\DisbursementStructure::find()->asArray()->all(),'disbursement_structure_id','structure_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
             [
                        'attribute' => 'user_id',
                        'vAlign' => 'middle',
                       // 'width' => '200px',
                        'value' => function ($model) {
                            return $model->user->firstname.' '.$model->user->middlename.' '.$model->user->surname;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>ArrayHelper::map(common\models\User::find()->where("login_type=5")->all(),'user_id',function ($user, $defaultValue)
                           {
                             return $user->firstname.' '.$user->surname.' '.$user->middlename;
                         }),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
          //  'user_id',
//            'created_at',
//            'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'deleted_by',
            // 'deleted_at',

             ['class' => 'yii\grid\ActionColumn',
             'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil" title="Edit"></span>',
                            $url);
                    },
                   

                ],
                ],
        ],
          'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
  </div>
</div>