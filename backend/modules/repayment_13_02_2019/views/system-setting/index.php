<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\SystemSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'General Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-setting-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('General Settings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'system_setting_id',
            //'setting_name',
            [
            'attribute'=>'setting_name',    
            'header'=>'Name',
            'format'=>'raw',    
            'value' => function($model)
            {
            return $model->setting_name;
            },
        ],
                    [
            'attribute'=>'setting_code',    
            'header'=>'Code',
            'format'=>'raw',    
            'value' => function($model)
            {
            return $model->setting_code;
            },
        ],
                    [
            'attribute'=>'setting_value',    
            'header'=>'Rate',
            'format'=>'raw',    
            'value' => function($model)
            {
            return $model->setting_value;
            },
        ],
            //'setting_value',
            'value_data_type',
                    [
            'attribute'=>'item_formula',
            'header'=>'Formula',
            'format'=>'raw',    
            'value' => function($model)
            {  
                            if($model->item_formula !=''){
            return $model->item_formula;
                            }else{
            return 'N/A';                    
                            }
            },
        ],
		[
            'attribute'=>'graduated_from',
            'header'=>'Graduated From',
            'format'=>'raw',    
            'value' => function($model)
            {  
                            if($model->graduated_from !=''){
            return $model->graduated_from;
                            }else{
            return 'N/A';                    
                            }
            },
        ],
		[
            'attribute'=>'graduated_to',
            'header'=>'Graduated To',
            'format'=>'raw',    
            'value' => function($model)
            {  
                            if($model->graduated_to !=''){
            return $model->graduated_to;
                            }else{
            return 'N/A';                    
                            }
            },
        ],
        [
            'attribute'=>'is_active',            
            'filter' => ['1'=>'Active', '0'=>'In Active'],
            //'format'=>'raw',    
            'value' => function($model, $key, $index)
            {   
                if($model->is_active == '1')
                {
                    return 'Active';
                }
                else
                {   
                    return 'In Active';
                }
            },
        ],

            ['class' => 'yii\grid\ActionColumn','template'=>'{update}'],
        ],
    ]); ?>
</div>
       </div>
</div>
