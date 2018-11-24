<script>
    function viewUploadedFile(url) {
        $('#view-attachment-dialog-id').dialog('open');
        $('#view-attachment-iframe-id').attr('src', url);
    }
    
     function uploadAttachment(url) {
        $('#create-attachment-dialog-id').dialog('open');
        $('#create-attachment-iframe-id').attr('src', url);
    }
    
    function reloadPage(url){
        document.location.href = url;
    }
</script>


<?php

use yii\data\SqlDataProvider;
use yii\grid\GridView;

$this->title = 'Applicant Attachments';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;



$sql = "select applicant_attachment.applicant_attachment_id, attachment_definition.attachment_desc, applicant_attachment.attachment_path, applicant_attachment.verification_status from attachment_definition inner join applicant_category_attachment on attachment_definition.attachment_definition_id = applicant_category_attachment.attachment_definition_id left join applicant_attachment on applicant_attachment.attachment_definition_id = attachment_definition.attachment_definition_id where applicant_category_attachment.applicant_category_id = 1 and attachment_definition.is_active = 1 and applicant_attachment.application_id = {$modelApplication->application_id} ";
$dataProvider = new SqlDataProvider([
    'sql' => $sql,
        ]);


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'Attachment',
            'value' => function($row) {
                return $row['attachment_desc'];
            }
        ],
        [
            'label' => 'Uploaded',
            'value' => function($row) {
                if ($row['attachment_path'] == NULL || $row['attachment_path'] == '') {
                    return yii\helpers\Html::label("NO", NULL, ['class' => 'label label-danger']);
                } else {
                    return yii\helpers\Html::label("YES", NULL, ['class' => 'label label-success']) . "&nbsp;&nbsp;" . yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $row['attachment_path'] . '")','class'=>'label label-primary']);
                }
            },
            'format' => 'raw',
        ],
        [
            'label' => '',
            'value' => function($row) {
              return yii\helpers\Html::a('UPLOAD | MODIFY', '#', ['class'=>'label label-primary','onclick'=>'uploadAttachment("'.\yii\helpers\Url::to(['applicant-attachment/update','id'=>$row['applicant_attachment_id']], true).'")']);  
            },
            'format'=>'raw',
        ],
    ]
]);

yii\jui\Dialog::begin([
    'id' => 'view-attachment-dialog-id',
    'clientOptions' => [
        'width' => '500',
        'height' => '400',
        'modal' => true,
        'autoOpen' => false,
    ]
]);

echo '<iframe src="" id="view-attachment-iframe-id" width="100%" height="100%" style="border: 0">';
echo '</iframe>';
echo '<br><br>';
yii\jui\Dialog::end();


yii\jui\Dialog::begin([
    'id' => 'create-attachment-dialog-id',
    'clientOptions' => [
        'width' => '500',
        'height' => '400',
        'modal' => true,
        'autoOpen' => false,
    ]
]);

echo '<iframe src="" id="create-attachment-iframe-id" width="100%" height="100%" style="border: 0">';
echo '</iframe>';
echo '<br><br>';
yii\jui\Dialog::end();
?>