<?php
//use yii\helpers\Html;
//use kartik\grid\GridView;
//use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\tabs\TabsX;
//use yii\bootstrap\Modal;
use yii\helpers\Url;
use frontend\modules\repayment\models\EmployedBeneficiary;

//use kartik\dialog\Dialog;
//use yii\jui\Dialog;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fixedassets */
$this->title = 'Loan Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fixedassets-view">
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-header with-border">
                <div class="box-body">
				<?php 
				if($employerSalarySource==0){ ?>
                    <?php echo Html::a('Add New Employee', ['create'], ['class' => 'btn btn-info']) ?>
                    <?php echo Html::a('Download Template', ['download'], ['class' => 'btn btn-warning']) ?>              
                        <?= Html::a('Upload New Employees', ['index-upload-employees'], ['class' => 'btn btn-primary']) ?>
                    <?php echo Html::a('Institutions Codes', ['learning-institutions-codes'], ['class' => 'btn btn-default']) ?>
					<?php }else{ ?>
					 <p class='alert alert-info'>
						You are required to select the salary source before you proceed with other functions.
						<?= Html::a('Click here to select salary source', ['/repayment/employer/update-salarysource', 'id' => $employerID], ['class'=>'alert-link']) ?>						
					</p>
					<?php } ?>
                </div>


            </div>


        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <?php
            echo TabsX::widget([
                'items' => [

                    [
                        'label' => 'Active Loan Beneficiaries',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/beneficiaries-verified']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '2',
                    ],
					[
                        'label' => 'Inactive Loan Beneficiaries',
                        'content' => '<iframe src="' . yii\helpers\Url::to(['employed-beneficiary/inative-beneficiaries']) . '" width="100%" height="600px" style="border: 0"></iframe>',
                        'id' => '2',
                    ],
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false
            ]);
            ?>			
        </div>

    </div>

    <div class="modal fade" id="modal-success">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>

                    <!--<h4 class="modal-title">Success Modal</h4>-->
                </div>
                <div class="modal-body">
                    <h4 class="modal-title">UPLOAD EMPLOYEES</h4>

                </div>
                <div class="modal-footer">
                    <!--                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-outline">Save changes</button>-->
                    <?php echo $this->render("upload", ['model' => new EmployedBeneficiary()]); ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



