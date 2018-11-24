<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Applicant */

$this->title = "Loanee Details";
$this->params['breadcrumbs'][] = ['label' => 'Loanee List', 'url' => ['/disbursement/default/applicant-profile']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="applicant-view">
   <div class="panel panel-info">
                        <div class="panel-heading">
                    
                        </div>
                        <div class="panel-body">
    <p>
        <?php
//        
//        <?= Html::a('Update', ['update', 'id' => $model->applicant_id], ['class' => 'btn btn-primary'])
  //<?= Html::a('Delete', ['delete', 'id' => $model->applicant_id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) 
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'applicant_id',
           // 'user_id',
            'NID',
            'f4indexno',
            'f6indexno',
            'mailing_address',
            'date_of_birth',
            'place_of_birth',
            'loan_repayment_bill_requested',
        ],
    ]) ?>

</div>
   </div>
</div>