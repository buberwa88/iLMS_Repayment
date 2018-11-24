
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterDefinition */

$this->title = 'Eligibility';
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
                            'label' => 'Check Eligibility',
                            'content' => $this->render('_check_eligibility', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]),
                            'id' => '1',
                        ],
                        [
                            'label' => 'Eligible Applicant',
                           // 'content' => $this->render('_eligible_applicant', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]),
                            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/default/eligible-applicant']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                             'id' => '2',
                        ],
                        [
                            'label' => 'Not Eligible Applicant',
                           // 'content' => $this->render('_eligible_applicant', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]),
                            'content' => '<iframe src="' . yii\helpers\Url::to(['/allocation/default/noteligible-applicant']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                             'id' => '2',
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
