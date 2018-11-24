<?php

use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\Question $model
 */

$this->title = "Update Basic Information";
$this->params['breadcrumbs'][] = ['label' => 'View Basic Information', 'url' => ['my-profile']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-create">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_profileform', [
                'model' => $model,
                'modelall' => $modelall,
                'modelapp' => $modelapp
            ])
            ?>

        </div>
    </div>
</div>
