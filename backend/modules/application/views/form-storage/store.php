<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/11/18
 * Time: 8:14 AM
 */

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = strtoupper('Application Forms Storage');
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/JsBarcode.all.min.js"></script>
<div class="panel panel-flat">
    <div class="panel-heading bg-primary">
        <?= Html::encode($this->title) ?>
        <span class="pull-right">
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/index')?>" class="btn btn-bitbucket btn-primary"><i class="fa fa-archive"></i> Folder List</a>
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/store')?>" class="btn btn-warning"><i class="fa fa-save"></i> Store Files</a>
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/retrieving')?>" class="btn btn-bitbucket btn-primary"><i class="fa fa-search"></i> Retrieve File</a>
                <a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/transfer')?>" class="btn btn-bitbucket btn-primary"><i class="fa fa-exchange"></i> Transfer Files</a>
            </span>
    </div>
    <div class="panel-body">
        <?php echo Yii::$app->controller->renderPartial('_storeForm'); ?>

    </div>

</div>