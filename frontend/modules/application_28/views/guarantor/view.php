<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Guarantor $model
 */
$this->title = 'Guarantors';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    function removeGuarantor(guarantor_id, name){
       if(confirm("Are you sure you want to remove "+name+"?")) {
           document.location.href = "<?=\yii\helpers\Url::to(['/application/guarantor/delete'])?>&id="+guarantor_id
       }
    }
</script>
<div class="guarantor-view">

 <?php
 echo Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success','style'=>'margin-top: -10px; margin-bottom: 5px']);   
 $models = frontend\modules\application\models\Guarantor::find()->all();
 $sn = 0;
    foreach ($models as $model) {
     ++$sn;   
    if ($model->type == 'G') {
        $attributes = [
            [
                'group' => true,
                'label' => 'GUARANTOR '.$sn.' - CATEGORY: ORGANIZATION ['.Html::a('EDIT', ['/application/guarantor/update','id'=>$model->guarantor_id]).'] &nbsp;&nbsp; ['.Html::a('REMOVE', '#',['onclick'=>'removeGuarantor('.$model->guarantor_id.',"'.$model->organization_name.'")']).']',
                'rowOptions' => ['class' => 'info'],
                'format'=>'raw',
            ],
            [
                'columns' => [

                    [
                        'label' => 'Name',
                        'value' => $model->organization_name,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute'=>'physical_address',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                    
                ],
            ],
            
            
            [
                'columns' => [

                    [
                        'attribute'=>'postal_address',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute'=>'email_address',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                ],
            ],
            
             [
                'columns' => [

                    [
                        'attribute'=>'postal_address',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute'=>'email_address',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                ],
            ],
            
             [
                'columns' => [

                    [
                        'attribute'=>'phone_number',
                        'labelColOptions'=>['style'=>'width:20%'],
                        
                    ],  
                ],
            ],
            
        ];
    } else {
        $attributes = [
            [
                'group' => true,
                'label' => 'GUARANTOR '.$sn.' - CATEGORY: INDIVIDUAL ['.Html::a('EDIT', ['/application/guarantor/update','id'=>$model->guarantor_id]).'] &nbsp;&nbsp; ['.Html::a('REMOVE', '#',['onclick'=>'removeGuarantor('.$model->guarantor_id.',"'.$model->firstname.' '.$model->surname.'")']).']',
                'rowOptions' => ['class' => 'info'],
                'format'=>'raw',
            ],
            [
                'columns' => [

                    [
                        'label' => 'Name',
                        'value' => $model->firstname." ".$model->middlename." ".$model->surname,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute'=>'sex',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                    
                ],
            ],
            
            
            [
                'columns' => [

                    [
                        'attribute'=>'occupation_id',
                        'value'=>  frontend\modules\application\models\Occupation::findOne($model->occupation_id)->occupation_desc,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute'=>'relationship_type_id',
                        'value'=>  frontend\modules\application\models\RelationshipType::findOne($model->relationship_type_id)->relationship_type,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                ],
            ],
            
             [
                'columns' => [

                    [
                        'attribute'=>'postal_address',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute'=>'email_address',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ]
                ],
            ],
            
             [
                'columns' => [

                    [
                        'attribute'=>'phone_number',
                        'labelColOptions'=>['style'=>'width:20%'],
                        
                    ],
                    
                ],
            ],
            
            [
                'columns' => [

                    [
                        'attribute'=>'passport_photo',
                        'labelColOptions'=>['style'=>'width:20%'],
                        'value'=>  Html::img("uploads/guarantor_photos/".$model->passport_photo, ['width'=>'100','height'=>'100']),
                        'format'=>'raw',
                        
                    ],
                    
                ],
            ],
            
        ];
    }

    echo DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);
    }
    ?>

</div>
