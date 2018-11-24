<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterDefinition */

$this->title = 'Higher Learning Institution Programmes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-definition-view">
    <div class="programme-index">
        <div class="panel panel-info">

            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">

                <p>
                    <?= Html::a('Create Programme', ['create'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Bulk Programmes Upload', ['/allocation/programme/bulk-upload'], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('Clone Programmes Costs', ['/allocation/programme/clone-programmes-costs'], ['class' => 'btn btn-warning']) ?>
                </p>

                <?php
                echo kartik\tabs\TabsX::widget([
                    'items' => [
                        [
                            'label' => 'Active Programmes',
                            'content' => $this->render('_active', ['dataProvider' => $dataProviderActive, 'searchModel' => $searchModel]),
                            'id' => '1',
                        ],
                        [
                            'label' => 'Pending Programmes',
                            'content' => $this->render('_inactive', ['dataProvider' => $dataProviderInActive, 'searchModel' => $searchModel]),
                            'id' => '1',
                        ], [
                            'label' => 'Inactive/Closed Programmes',
                            'content' => $this->render('_closed', ['dataProvider' => $dataProviderClosed, 'searchModel' => $searchModel]),
                            'id' => '1',
                        ],
                    ],
                    'position' => kartik\tabs\TabsX::POS_ABOVE,
                    'bordered' => true,
                    'encodeLabels' => false
                ]);
                ?>


            </div>
        </div>
    </div>
</div>