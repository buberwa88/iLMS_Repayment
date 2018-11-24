<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\PayoutlistMovementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payout List Movement';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payoutlist-movement-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'movement_id',
            'disbursements_batch_id',
              [
                     'attribute' => 'from_officer',
                        'label'=>"From  Officer",
                        'vAlign' => 'middle',
                       // 'width' => '200px',
                        'value' => function ($model) {
                           //return $model->fromOfficer->firstname." ".$model->fromOfficer->middlename." ".$model->fromOfficer->surname;
                        },
                    ],
              [
                     'attribute' => 'to_officer',
                        'label'=>"To Officer",
                        'vAlign' => 'middle',
                       // 'width' => '200px',
                        'value' => function ($model) {
                            //return $model->toOfficer->firstname." ".$model->toOfficer->middlename." ". $model->toOfficer->surname;
                        },
                    ],
            //'to_officer',
            //'',
             [
                     'attribute' => 'movement_status',
                       // 'label'=>"From  Officer",
                        'vAlign' => 'middle',
                      //  'width' => '200px',
                        'value' => function ($model) {
                            return $model->movement_status==0?"Pending":"Inmovement";
                        },
                    ],
           //  'date_in',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
 </div>
</div>