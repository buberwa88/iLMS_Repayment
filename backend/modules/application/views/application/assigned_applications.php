<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Assigned Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">
<div class="panel panel-info">
    <div class="panel-heading">
         
     <?= Html::encode($this->title) ?>
          
    </div>
    <div class="panel-body">
    <p>
        <?= Html::a('Reverse In Bulk', ['verification-assignment/reverse-applicationbulk'], ['class' => 'btn btn-success']) ?>
    </p>
        <p >
        <?=Html::beginForm(['application/reverseapplication-assigned'],'post');?>        
              <div class="text-right">
    <?=Html::submitButton('<i class="fa fa-repeat"></i> Reverse', ['class' => 'btn btn-warning',]);?>
        </div>  
    </p>
 
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
             [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
                    ],
                                
              [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
                    ],
                    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
                    ],                  
                 [
                     'attribute' => 'applicant_category_id',
                        'label'=>"Category",
                        'value' => function ($model) {
                            return $model->applicantCategory->applicant_category;
                        },
                    ],
 

                   [
                     'attribute' => 'verification_status',
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->verification_status ==0){
                                     return Html::label("Unvarified", NULL, ['class'=>'label label-default']);
                                    } else if($model->verification_status==1) {
                                        return Html::label("Complete", NULL, ['class'=>'label label-success']);
                                    }
                                   else if($model->verification_status==2) {
                                        return Html::label("Incomplete", NULL, ['class'=>'label label-danger']);
                                    }
                                  else if($model->verification_status==3) {
                                        return Html::label("Waiting", NULL, ['class'=>'label label-warning']);
                                    }
                        },
                        'format' => 'raw'
                    ],  
                                [
                     'attribute' => 'assignee',
                     'label'=>'Assignee',
                        'value' => function ($model) {
                                   
                                     return $model->assignee0->firstname." ".$model->assignee0->middlename." ".$model->assignee0->surname;
                                    
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        //'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                        'filter' =>ArrayHelper::map(\common\models\User::findBySql('SELECT user.user_id,CONCAT(user.firstname," ",user.surname) AS "Name" FROM `user` INNER JOIN application ON application.assignee=user.user_id  WHERE user.login_type=5 AND (application.verification_status="0" OR application.verification_status="2" OR application.verification_status="3")')->asArray()->all(), 'user_id', 'Name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search  '],
                        'format' => 'raw'        
                    ],
                                ['class' => 'yii\grid\CheckboxColumn'],
        ],
    ]); ?>
    <div class="text-right">
    <?=Html::submitButton('<i class="fa fa-repeat"></i> Reverse', ['class' => 'btn btn-warning',]);?>
        </div>
    <?= Html::endForm();?>
</div>
</div>
</div>
