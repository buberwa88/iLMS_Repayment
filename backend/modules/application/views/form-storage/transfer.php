<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/20/18
 * Time: 3:14 PM
 */
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = strtoupper('Application Forms Retrieval');
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/JsBarcode.all.min.js"></script>
<!--<script src="../ExtraPlugins/datatables/jquery.dataTables.min.js"></script>
<script src="../ExtraPlugins/datatables/dataTables.bootstrap.min.js"></script>-->
<div class="panel panel-flat">
    <div class="panel-heading bg-primary">
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/index')?>" class="btn  btn-bitbucket btn-primary"><i class="fa fa-archive"></i> Folder List</a>
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/store')?>" class="btn btn-bitbucket btn-primary"><i class="fa fa-save"></i> Store Files</a>
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/retrieving')?>" class="btn btn-bitbucket"><i class="fa fa-search"></i> Retrieve File</a>
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/transfer')?>" class="btn btn-warning"><i class="fa fa-exchange"></i> Transfer Files</a>
            </span>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php echo Yii::$app->controller->renderPartial('_transferForm'); ?>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-5">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="text-center text-uppercase">Source <span class="panel-body pull-right bg-green" style="font: large;"><span id="sourceSelection">0</span><span>/</span><span id="sourceLimit">0</span></span></h3>
            </div>

            <div class="panel-body" id="source_folder"></div>

        </div>
    </div>
    <div class="col-md-2 text-center"><button class="btn btn-large btn-primary" id="btnTransfer"><span class="fa fa-arrow-right fa-5x"></span></button></div>
    <div class="col-md-5">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="text-center text-uppercase">Destination <span class="panel-body pull-right bg-primary" style="font: large;"><span id="destinationSelection">0</span><span>/</span><span id="destinationLimit">0</span></span></h3>
            </div>
            <div class="panel-body" id="destination_folder"></div>
        </div>
    </div>
</div>
