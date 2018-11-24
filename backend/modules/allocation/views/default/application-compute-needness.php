
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterDefinition */

$this->title = 'Compute Needness for Continous';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-definition-view">
    <div class="programme-index">
        <div class="panel panel-info">

            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
 
                <?php
                echo kartik\tabs\TabsX::widget([
                    'items' => [
                        [
                            'label' => 'Compute Needness',
                            'content' => $this->render('compute_needness_cont', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]),
                            'id' => '1',
                        ],
                        [
                            'label' => 'Completed Needness',
                           // 'content' => $this->render('_eligible_applicant', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]),
                            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/allocation-process/needness-continous-applicant']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                             'id' => '2',
                        ],
                        [
                            'label' => 'Failed to Compute Needness',
                           // 'content' => $this->render('_eligible_applicant', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]),
                            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/allocation-process/needness-continous-problem']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                             'id' => '3',
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