<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Request GSPP Monthly Deductions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
<div class="panel-heading">
					  <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body"> 
<p>
<?= Html::a('Reguset GSPP Monthly Deductions', ['requestgspp-monthdeductionform'], ['class' => 'btn btn-success','onclick'=>'return  check_status()']) ?>
</p>
</div>
       </div>
</div>
