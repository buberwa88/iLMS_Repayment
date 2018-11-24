<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\VerificationCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verification Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="verification-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Verification Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           //'verification_comment_group_id',

[
                     'attribute' => 'attachment_definition_id',
                        'label'=>"Attachment",
                        'format' => 'raw',
                        'value' => function ($model) {
                            
                             return $model->attachmentDefinition->attachment_desc;   
                            
                        },
                    ],

           [
                     'attribute' => 'verification_comment_group_id',
                        'label'=>"Comment",
                        'format' => 'raw',
                        'value' => function ($model) {
                            
                             return $model->verificationCommentGroup->comment_group;   
                            
                        },
            ],
            //'comment',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',
                ],
        ],
    ]); ?>
</div>
