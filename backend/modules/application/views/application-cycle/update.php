
<?php

use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\Question $model
 */

$this->title = 'Open or Close Application: ';
$this->params['breadcrumbs'][] = ['label' => 'Manage Application Status', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="application-cycle-status-update">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_search', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
