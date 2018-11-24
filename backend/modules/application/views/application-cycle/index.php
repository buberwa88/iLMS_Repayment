<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\AcademicYear;
use backend\modules\application\models\ApplicationCycleStatus;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\application\models\QtriggerMainSearch $searchModel
 */

$this->title = 'Open or Close Application';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qtrigger-main-index">
  <div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
  <div class="panel-body">
    <div class="col-xs-12">
            <div class="box box-primary">
                  <div class="bank-form" style="margin: 1%;overflow: hidden">
                    <?php 
                       $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); 
                        echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 1,
                         'attributes' => [                 
                           'academic_year_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(AcademicYear::find()->where(['is_current' => 1])->all(), 'academic_year_id', 'academic_year'),  'options' => ['prompt' => '--select year--']],
                            'application_cycle_status_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(ApplicationCycleStatus::find()->all(), 'application_cycle_status_id', 'application_cycle_status_name'),  'options' => ['prompt' => '--select status--']],
                             'application_status_remark' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Application Status Remarks...', 'maxlength' => 500]],
                           ]
                      ]);
                     echo Html::submitButton('Submit', ['class' => 'btn btn-success', 'style' => 'float: right;margin:5px;']);
                     ActiveForm::end();
                  ?>
                </div> 
            </div>
        </div>

    <div class="col-xs-12">
    <div class="box box-primary">
    <?php  echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
              //'application_cycle_id',
              [
                     'attribute' => 'academic_year_id',
                        'label'=>"Academic Year",
                        'value' => function ($model) {
                            return $model->academicYear->academic_year;
                        },
              ],
              [
                     'attribute' => 'application_cycle_status_id',
                        'label'=>"Application Status",
                        'value' => function ($model) {
                            return $model->applicationCycleStatus->application_cycle_status_name;
                        },
              ],
               [
                     'attribute' => 'application_status_remark',
                        'label'=>"Remarks",
                        'value' => function ($model) {
                            return $model->application_status_remark;
                        },
              ],
             [
                'class' => 'yii\grid\ActionColumn',
                //'template'=>'{update}{delete}'
                'template'=>''
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
    ]); 
     //echo Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']);
   ?>
</div>
</div>
</div>
</div>
</div>
