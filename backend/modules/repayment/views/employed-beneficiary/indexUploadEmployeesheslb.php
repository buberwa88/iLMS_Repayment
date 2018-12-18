<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Upload Employees';
$this->params['breadcrumbs'][] = ['label' => 'Employer', 'url' => ['employer/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
            <p><?php echo Html::a('Download Template', ['download'], ['class' => 'btn btn-warning']) ?>
            </p>
            <br/>
            <?=
            $this->render('upload', [
                'model' => $model,'employerID'=>$employerID
            ])
            ?>
</div>
       </div>
</div>
