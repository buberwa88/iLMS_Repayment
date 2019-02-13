<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundLetterFormat */

$this->title = "Refund Letter Format ";
$this->params['breadcrumbs'][] = ['label' => 'Refund Letter Format', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-letter-format-view">
 <div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
        <p class="pull-right">
             <?= Html::a('Update', ['update', 'id' => $model->refund_letter_format_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->refund_letter_format_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
     </p>
<?php 
    $gridColumn = [
        //'refund_letter_format_id',
        'letter_name',
        'header',
        'footer',
        'letter_heading',
        //'letter_body:ntext',
       // 'is_active',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
<p><b>Letter Body</b></p>
<?=$model->letter_body;?>
    </div>
   