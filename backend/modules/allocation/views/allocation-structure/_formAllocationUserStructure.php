<div class="form-group" id="add-allocation-user-structure">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\User;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'AllocationUserStructure',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        'allocation_user_structure_id' => ['type' => TabularForm::INPUT_HIDDEN,'label'=>''],
        'user_id' => [
            'label' => 'User Staff',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(User::find()->where(['login_type'=>5])->orderBy('username')->asArray()->all(), 'user_id', 'username'),
                'options' => ['placeholder' => 'Choose User Staff'],
            ],
         //   'columnOptions' => ['width' => '200px']
        ],
       // 'status' => ['type' => TabularForm::INPUT_TEXT],
        'status' => [
            'label' => 'Status',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => [0=>"In Active",1=>'Active'],
                'options' => ['placeholder' => 'Choose Status'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowAllocationUserStructure(' . $key . '); return false;', 'id' => 'allocation-user-structure-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Allocation User Structure', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowAllocationUserStructure()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

