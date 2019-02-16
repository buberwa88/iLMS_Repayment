<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundComment */

$this->title = "Refund Comment Details";
$this->params['breadcrumbs'][] = ['label' => 'Refund Comment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-comment-view">
 <div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Refund Comment'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Update', ['update', 'id' => $model->refund_comment_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->refund_comment_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
       // 'refund_comment_id',
        [
            'attribute' => 'attachmentDefinition.attachment_desc',
            'label' => 'Attachment ',
        ],
        'comment',
        'is_active',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
  </div>
</div>
</div>