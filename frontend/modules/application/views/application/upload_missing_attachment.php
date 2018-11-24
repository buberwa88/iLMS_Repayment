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
        document.location.href ='index.php?r=application/application/upload-missing-attachment';
    }
</script>


<?php
 
use yii\grid\GridView;
use yii\helpers\Html;
use frontend\modules\application\models\ApplicantAttachment;
$this->title = 'List of Missing Applicant Attachments';
//$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;



/*$sql = "select applicant_attachment.applicant_attachment_id, attachment_definition.attachment_desc, applicant_attachment.attachment_path, applicant_attachment.verification_status from attachment_definition inner join applicant_category_attachment on attachment_definition.attachment_definition_id = applicant_category_attachment.attachment_definition_id left join applicant_attachment on applicant_attachment.attachment_definition_id = attachment_definition.attachment_definition_id where applicant_category_attachment.applicant_category_id = 1 and attachment_definition.is_active = 1 and applicant_attachment.application_id = {$modelApplication->application_id} ";
$dataProvider = new SqlDataProvider([
    'sql' => $sql,
        ]);*/
?>
<div class="allocation-batch-create">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title); ?>
        </div>
        <div class="panel-body">
		<?php //if($application_id==1){?>
		<div class="callout callout-success">  
          <p>Please click the "Download Loan Application Form(PDF) button below to download the Application Form for Signatures and Certification processes if needed in the list of attachment(s) mentioned below". Thanks!!!</p>
        </div>

      <div class="row no-print">
        <div class="col-xs-12">

              <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/application-original-form'])?>" target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Download Loan Application Form(PDF)</a>


        </div>
    </div>
		<?php //} ?>
<?php 

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'label' => 'Attachment',
            'value' => function($row) {
            return $row->attachmentDefinition->attachment_desc;
            }
        ],
        [
            'label' => 'Uploaded',
            'value' => function($row) {
            if ($row->verification_status>0&&$row->submited==0) {
                    return yii\helpers\Html::label("NO", NULL, ['class' => 'label label-danger']);
                } else {
                    return yii\helpers\Html::label("YES", NULL, ['class' => 'label label-success']) . "&nbsp;&nbsp;" . yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("'.$row->attachment_path.'")','class'=>'label label-primary']);
                }
            },
            'format' => 'raw',
        ],
        [
            'label' => '',
            'value' => function($row) {
            if ($row->submited<2) {
              return yii\helpers\Html::a('UPLOAD | MODIFY', '#', ['class'=>'label label-primary','onclick'=>'uploadAttachment("'.\yii\helpers\Url::to(['applicant-attachment/update','id'=>$row->applicant_attachment_id], true).'")']);  
            }
            else{
               return 'Submitted';
            }
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
        'width' => '600',
        'height' => '400',
        'modal' => true,
        'autoOpen' => false,
    ]
]);
echo '<iframe src="" id="create-attachment-iframe-id" width="100%" height="100%" style="border: 0">';
echo '</iframe>';
echo '<br><br>';
yii\jui\Dialog::end();
//submit missing attachment
$query = ApplicantAttachment::find()->where("application_id='{$application_id}' AND submited=0")->count();
//end 
if($query>0){
?>
   <div class="row no-print">
        <div class="col-xs-12">

           <a href="<?= Yii::$app->urlManager->createUrl(['/application/application/submit-attachment'])?>"class="btn btn-success pull-right"><i class="fa fa-submit"></i>SUBMIT ATTACHMENT</a>

        </div>
    </div>
    
    <?php } ?>