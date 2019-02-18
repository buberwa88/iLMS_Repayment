<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Staffs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
<div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
            <p>
        <?= Html::a('Create Staff', ['create-user'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'user_id',
            'firstname',
           // 'middlename',
            'surname',
           // 'sex',
             'username',
            // 'password_hash',
            // 'security_question_id',
            // 'security_answer',
             'email_address:email',
            // 'passport_photo',
             'phone_number',
            // 'is_default_password',
            // 'status',
            // 'status_comment:ntext',
            // 'login_counts',
            // 'last_login_date',
            // 'date_password_changed',
            // 'auth_key',
            // 'password_reset_token',
            // 'activation_email_sent:email',
            // 'email_verified:email',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'login_type',
            //['class' => 'yii\grid\ActionColumn','template'=>'{update}'],
			
			
			['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{update}',
			 'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'update'),
                    ]);
                },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                if ($action === 'update') {
                    $url = 'index.php?r=application/user/update-staff&id=' . $model->user_id;
                    return $url;
                }
            }
			],
			
			
            /*
             [
               'label'=>'',
                  'width' => '155px',
               'value'=>function($model){
                             if($model->status==10){
                                  $status=0;  
                                  $label='Deactivate';
                                }
                                else{
                                  $status=10; 
                                  $label='Activate';
                                }
                  return Html::a(" $label ", ['/application/user/manage-account','id'=>$model->user_id,'status'=>$status], ['class'=>'label label-primary'])."&nbsp;&nbsp; &nbsp;&nbsp;  ".Html::a("Details", ['/application/user/view','id'=>$model->user_id], ['class'=>'label label-success']);
               },
               'format'=>'raw',
             ],
             * 
             */
        ],
    ]); ?>
</div>
</div>
</div>
