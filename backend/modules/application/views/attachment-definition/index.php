<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\AttachmentDefinitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verification Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachment-definition-index">
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

            //'attachment_definition_id',
            'attachment_desc',
            //'max_size_MB',
            //'require_verification',
            [
                     'attribute' => 'require_verification',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->require_verification ==0){
                                     return Html::label("No", NULL, ['class'=>'label label-danger']);
                                    } else if($model->require_verification==1) {
                                        return Html::label("Yes", NULL, ['class'=>'label label-success']);
                                    }
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>"Yes",0=>'No'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            'verification_prompt',
            [
                     'attribute' => 'is_active',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->is_active ==0){
                                     return Html::label("No", NULL, ['class'=>'label label-danger']);
                                    } else if($model->is_active==1) {
                                        return Html::label("Yes", NULL, ['class'=>'label label-success']);
                                    }
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>"Yes",0=>'No'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            //'is_active',
             [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}'
            ],         
        ],
            'responsive' => true,
            'hover' => true,
            'condensed' => true,
    ]); 
?>
<div class="text-right">
<?php
    echo Html::a('<i class="glyphicon glyphicon-plus"></i> Add New Verification Item', ['create'], ['class' => 'btn btn-success']);

    ?>
</div>
    </div>
  </div>
</div>

