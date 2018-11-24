<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\LearningInstitutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Learning Institutions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Learning Institution', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'learning_institution_id',
                    //'institution_type',
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'allowBatchToggle' => true,
                        'detail' => function ($model) {
                            return $this->render('view', ['model' => $model]);
                        },
                                'detailOptions' => [
                                    'class' => 'kv-state-enable',
                                ],
                            ],
                            [
                                'attribute' => 'institution_type',
                                'vAlign' => 'middle',
                                'width' => '200px',
                                'value' => function ($model) {
                                    return $model->institution_type;
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' =>backend\modules\allocation\models\LearningInstitution::getInstitutionTypes(),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Search'],
                                'format' => 'raw'
                            ],
                            'institution_code',
                            'institution_name',
                            //'parent.institution_name',
                            [
                                'attribute' => 'parent_id',
                                'vAlign' => 'middle',
                                'width' => '200px',
                                'value' => function ($model) {
                                    return $model->parent->institution_name;
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ArrayHelper::map(\backend\modules\application\models\LearningInstitution::find()->where(["institution_type" => "UNIVERSITY"])->asArray()->all(), 'learning_institution_id', 'institution_name'),
                                'filterWidgetOptions' => [
                                    'pluginOptions' => ['allowClear' => true],
                                ],
                                'filterInputOptions' => ['placeholder' => 'Search'],
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'ownership',
                                'value' => function($model) {
                                    return $model->getOwnershipNameByValue();
                                }
                            ],
                            [
                                'attribute' => 'country',
                                'label' => 'Country of Study',
                                'value' => function($model) {
                                    return common\models\Country::getCountryNameByCode($model->country);
                                }
                            ],
                            [
                                'attribute' => 'is_active',
                                'value' => function($model) {
                                    return $model->getStatusNameByValue();
                                }
                            ],
                            //  'institution_phone',
                            // 'institution_address',
                            // 'ward_id',
                            // 'bank_account_number',
                            // 'bank_account_name',
                            // 'bank_id',
                            // 'bank_branch_name',
                            // 'entered_by_applicant',
                            // 'created_at',
                            // 'created_by',
                            // 'contact_firstname',
                            // 'contact_middlename',
                            // 'contact_surname',
                            // 'contact_email_address:email',
                            // 'contact_phone_number',
                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}{update}{delete}'],
                        ],
                        'hover' => true,
                        'condensed' => true,
                        'floatHeader' => true,
                    ]);
                    ?>
        </div>
    </div>
</div>