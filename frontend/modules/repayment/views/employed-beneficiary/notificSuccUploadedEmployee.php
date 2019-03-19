<?php
//use yii\helpers\Html;
//use kartik\grid\GridView;
//use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\tabs\TabsX;
//use yii\bootstrap\Modal;
use yii\helpers\Url;
use frontend\modules\repayment\models\EmployedBeneficiary;

//use kartik\dialog\Dialog;
//use yii\jui\Dialog;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */
$this->title = 'Successful Added/Uploaded New Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
                    <?php
            echo TabsX::widget([
                'items' => [

                    [
                        'label' => 'Confirm New Added/Uploaded Employees',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/un-verified-uploaded-employees']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '1',
                    ],
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false
            ]);
            ?>	                		
        </div>

    </div>
</div>


