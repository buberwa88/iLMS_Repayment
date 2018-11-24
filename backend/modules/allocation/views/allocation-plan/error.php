<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'System Error';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-setting-index">
    <div class="panel panel-info">
        <div class="panel-heading warning">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body failed">
            <p>
                <?php
                echo $exception->errorInfo[2];
                ?>
            </p>

        </div>
    </div>
</div>
