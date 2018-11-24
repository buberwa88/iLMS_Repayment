<?php   
    use yii\helpers\Html;
    use kartik\widgets\ActiveForm;
    use kartik\builder\Form;
    
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
    echo Form::widget([
    'model'=>$model1,
    'form'=>$form,
    'columns'=>2,
    'attributes'=>[ // 2 column layout
    'employer_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter username...']],
    'employer_type'=>['type'=>Form::INPUT_PASSWORD, 'options'=>['placeholder'=>'Enter password...']]
    ]
    ]);
    echo Form::widget([ // 1 column layout
    'model'=>$model1,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
    'short_name'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter notes...']],
    ]
    ]);
    echo Form::widget([ // nesting attributes together (without labels for children)
    'model'=>$model1,
    'form'=>$form,
    'columns'=>2,
    'attributes'=>[    
    'time_range'=>[
    'label' => 'Time Range',
    'attributes'=>[
    'company_nature_of_work'=>[
    'type'=>Form::INPUT_WIDGET,
    'widgetClass'=>'\kartik\widgets\TimePicker',
    'options'=>['options'=>['placeholder'=>'Time from...']],
    ],
    'postal_address'=>[
    'type'=>Form::INPUT_WIDGET,
    'widgetClass'=>'\kartik\widgets\TimePicker',
    'options'=>['options'=>['placeholder'=>'Time to...', 'class'=>'col-md-9']]
    ],
    ]
    ],
    ]
    ]);
    echo Form::widget([ // 3 column layout
    'model'=>$model1,
    'form'=>$form,
    'columns'=>3,
    'attributes'=>[
    'physical_address'=>[
    'type'=>Form::INPUT_WIDGET,
    'widgetClass'=>'\kartik\widgets\DatePicker',
    'hint'=>'Enter birthday (mm/dd/yyyy)'
    ],
    'ward_id'=>[
    'type'=>Form::INPUT_WIDGET,
    'widgetClass'=>'\kartik\widgets\Select2',
    //'options'=>['data'=>$model1->typeahead_data],
    'hint'=>'Type and select state'
    ],
    'phone_number'=>[
    'type'=>Form::INPUT_WIDGET,
    'widgetClass'=>'\kartik\widgets\ColorInput',
    'hint'=>'Choose your color'
    ],
    'district'=>[
    'type'=>Form::INPUT_RADIO_LIST,
    'items'=>[true=>'Active', false=>'Inactive'],
    'options'=>['inline'=>true]
    ],
    'district'=>[
    'type'=>Form::INPUT_WIDGET,
    'label'=>Html::label('Brightness (%)'),
    'widgetClass'=>'\kartik\widgets\RangeInput',
    'options'=>['width'=>'80%']
    ],
    'actions'=>[
    'type'=>Form::INPUT_RAW,
    'value'=>'<div style="text-align: right; margin-top: 20px">' .
    Html::resetButton('Reset', ['class'=>'btn btn-default']) . ' ' .
    Html::button('Submit', ['type'=>'button', 'class'=>'btn btn-primary']) .
    '</div>'
    ],
    ]
    ]);
    ActiveForm::end();
    ?>