<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/20/18
 * Time: 7:18 AM
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
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/retrieving')?>" class="btn btn- btn-warning"><i class="fa fa-search"></i> Retrieve File</a>
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/transfer')?>" class="btn btn-bitbucket btn-primary"><i class="fa fa-exchange"></i> Transfer Files</a>
            </span>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php echo Yii::$app->controller->renderPartial('_retrievalForm'); ?>
        </div>

        <div class="row">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr class="bg-primary">
                        <th width="5%">S/N</th>
                        <th width="15%">Index #</th>
                        <th width="20%">Applicant Name</th>
                        <th width="10%">Form #</th>
                        <th width="15%">Folder #</th>
                        <th width="10%">Sequence #</th>
                        <th width="15%">Remarks</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody id="results_preview"></tbody>
            </table>
        </div>


    </div>

</div>
