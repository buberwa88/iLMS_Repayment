<?php

use yii\helpers\Html;
use frontend\modules\application\models\AttachmentDefinition;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\ApplicantAttachment $model
 */

if($uploaded){
    echo "<script>parent.reloadPage('".\yii\helpers\Url::to(['/application/applicant-attachment/index'], true)."');</script>";
}

echo "<p class='alert alert-info'>";
echo "Please upload your ".AttachmentDefinition::findOne($model->attachment_definition_id)->attachment_desc.". ";
echo "Please NOTE; If you had already uploaded, that existing document will be replaced";
echo "</p>";
?>
<div class="applicant-attachment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
