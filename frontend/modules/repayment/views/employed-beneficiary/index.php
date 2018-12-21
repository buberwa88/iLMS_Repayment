<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Upload Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
            <p><?php echo Html::a('Download Template', ['download'], ['class' => 'btn btn-warning']) ?>
               <?php //echo Html::a('Institutions Codes', ['learning-institutions-codes'], ['class' => 'btn btn-success']) ?>
               <?php //echo Html::a('Study Level', ['study-level'], ['class' => 'btn btn-default']) ?>
               <?php //echo Html::a('Programmes', ['programme'], ['class' => 'btn btn-primary']) ?>
            </p>
            <br/>
            <?=
            $this->render('upload', [
                'model' => $model,
            ])
            ?>
</div>
       </div>
</div>
