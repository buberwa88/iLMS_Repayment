 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
    'user_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Loan Board Staff',
                'options' => [
                    'data' =>ArrayHelper::map(common\models\User::find()->where("login_type=5")->all(),'user_id',function ($user, $defaultValue)
       {
        return $user->firstname.' '.$user->surname.' '.$user->middlename;
      }),
                    'options' => [
                        'prompt' => 'Loan Board Staff',
                       
                    ],
                ],
            ],
      'disbursement_structure_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Structure Name',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\disbursement\models\DisbursementStructure::find()->all(),'disbursement_structure_id','structure_name'),
                    'options' => [
                        'prompt' => 'Select Disbursement Structure',
                        //'onchange'=>'myprogramme(this)',
                        'allowClear' => true,
                    
                    ],
                ],
            ],

    ]
]);
 
?>
 
  <div class="text-right">
        
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
 
    </div>
