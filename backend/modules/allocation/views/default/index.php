<?php
use common\models\AcademicYear;
?>
 
<?php
 
  $totalallocationbatch=  \backend\modules\allocation\models\AllocationBatch::find()->where(['academic_year.is_current'=>1])->joinWith("academicYear")->count();
   //academic year
   $model_academic=AcademicYear::findOne(["is_current"=>1])
?>  
<?php
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use backend\modules\application\models\Application;
use backend\modules\application\models\Applicant;
use backend\modules\allocation\models\Allocation;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\BankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$user_id = Yii::$app->user->identity->id;
$modelUser = common\models\User::findone($user_id);
$username=strtoupper($modelUser->firstname).' '.strtoupper($modelUser->middlename).' '.strtoupper($modelUser->surname);

//$applicants_who_paid_fee = Application::find()->where(['academic_year.is_current'=>1])->joinWith("academicYear")->count();
$applicants_eligible = Application::find()->where("released>=1 AND academic_year_id='{$model_academic->academic_year_id}' AND allocation_status IN(1,3,4,5,6)")->count();
$applicants_verified=Application::find()->where("released>=1 AND academic_year_id='{$model_academic->academic_year_id}'")->count();
//$total_fee_collected = ($applicants_who_paid_fee -1) * 30000 + 1500;

$female_applicants = Allocation::find()->joinWith("application")->joinWith("allocationBatch")->joinWith("application.applicant")->where("is_approved=1 AND sex='F' AND released>=1 AND allocation_batch.academic_year_id='{$model_academic->academic_year_id}'")->count();
$male_applicants = Allocation::find()->joinWith("application")->joinWith("allocationBatch")->joinWith("application.applicant")->where("is_approved=1 AND sex='M' AND released>=1 AND allocation_batch.academic_year_id='{$model_academic->academic_year_id}'")->count();

$allocated_applicants = Allocation::find()->joinWith("allocationBatch")->where(['is_approved'=>1,'academic_year_id'=>$model_academic->academic_year_id])->count();

//find amount allocated
$allocated_amount = Allocation::find()->joinWith("allocationBatch")->where(['is_approved'=>1,'academic_year_id'=>$model_academic->academic_year_id])->sum("allocated_amount");
//end
//$submitted_applications = Application::find()->where(['loan_application_form_status' => 2])->count();
//$complete_applications = Application::find()->where(['loan_application_form_status' => 3])->count();
//$incomplete_applications = Application::find()->where(['verification_status' => 2])->count();
$fresher_applications = Application::find()->where("released>=1 AND academic_year_id='{$model_academic->academic_year_id}' AND progress_status=1")->count();
$continuous_applications = Application::find()->where("released>=1 AND academic_year_id='{$model_academic->academic_year_id}' AND progress_status=2")->count();
$diploma_applications = Application::find()->where(['applicant_category_id' => 3])->count();
$undergraduate_applications = Application::find()->where(['applicant_category_id' => 1])->count();
$postgraduate_applications = Application::find()->where(['applicant_category_id' => [2,4,5]])->count();
//$verified_applications = Application::find()->count();
$undergraduate_applications = Allocation::find()->joinWith("application")->joinWith("allocationBatch")->joinWith("application.applicant")->where("is_approved=1 AND applicant_category_id=1 AND released>=1 AND allocation_batch.academic_year_id='{$model_academic->academic_year_id}'")->count();
$postgraduate_applications = Allocation::find()->joinWith("application")->joinWith("allocationBatch")->joinWith("application.applicant")->where("is_approved=1 AND applicant_category_id IN(2,4,5) AND released>=1 AND allocation_batch.academic_year_id='{$model_academic->academic_year_id}'")->count();
$diploma_applications = Allocation::find()->joinWith("application")->joinWith("allocationBatch")->joinWith("application.applicant")->where("is_approved=1 AND applicant_category_id=3 AND released>=1 AND allocation_batch.academic_year_id='{$model_academic->academic_year_id}'")->count();
//start
$allocated_amount_fresher= Allocation::find()->joinWith("application")->joinWith("allocationBatch")->joinWith("application.applicant")->where("is_approved=1 AND released>=1 AND allocation_batch.academic_year_id='{$model_academic->academic_year_id}' AND progress_status=1 ")->sum("allocated_amount");
//$allocated_amount_fresher = Allocation::find()->joinWith("allocationBatch")->where(['is_approved'=>1,'academic_year_id'=>$model_academic->academic_year_id])->sum("allocated_amount");
$allocated_applicants_continous= Allocation::find()->joinWith("application")->joinWith("allocationBatch")->joinWith("application.applicant")->where("is_approved=1 AND released>=1 AND allocation_batch.academic_year_id='{$model_academic->academic_year_id}' AND progress_status=2 ")->sum("allocated_amount");
$this->title ="Dashboard";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="application-view">
   <div class="panel panel-info">

       <div class="callout callout-info">
          <h4 style="margin: 2px"><b>Welcome <?= $username;?>{Administrative User}</b></h4>
        </div>
<section class="content">
      <!-- Small boxes (Stat box) -->
      <!-- FIRST ROW GRAPHICAL DATA -->
           <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Verified Applicants</span>
              <span class="info-box-number"><?= number_format($applicants_verified);?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"></span>

             <div class="info-box-content">
              <span class="info-box-text">Eligible Applicants</span>
              <span class="info-box-number"><?= number_format($applicants_eligible);?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Allocated Amount</span>
              <span class="info-box-number"><?= number_format($allocated_amount); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
      </div>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Means Tested Applicants</span>
              <span class="info-box-number"><?= number_format($applicants_eligible);?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"></span>

            <div class="info-box-content">
              <span class="info-box-text">Applicants Confirmed  <br/> for disbursement</span>
              <span class="info-box-number"><?= number_format($allocated_applicants); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Allocated Amount <br/> for Fresher</span>
              <span class="info-box-number"><?= number_format($allocated_amount_fresher); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
         <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Allocated Amount <br/>for Continous</span>
              <span class="info-box-number"><?= number_format($allocated_applicants_continous); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>

<!-- SECOND ROW GRAPHICAL DATA -->
      <div class="row">
        <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">APPLICATIONS BY STATUS</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>

              </div>
            </div>
              <div class="box-body">
        <div class="chart">
            <?php
            $fee_column_data = [[0 => 'Fresher Applicants( '.number_format($fresher_applications).' )', 1 => doubleval($fresher_applications)], [0 => 'Continuous Applicants ('.number_format($continuous_applications).' )', 1 => doubleval($continuous_applications)]];
        echo Highcharts::widget([
            'options' => [
                'chart' => ['type' => 'pie', 'height' => '295', 'plotBackgroundColor' => null,
                    'plotBorderWidth' => null,
                    'plotShadow' => false],
                'title' => ['text' => ''],
                'tooltip' => [
                    'pointFormat' => '{series.name}:
                        <b>{point.percentage:.1f}%</b>'
                ],
                'plotOptions' => [
                    'pie' => [
                        'allowPointSelect' => true,
                        'cursor' => 'pointer',
                        'dataLabels' => [
                            'enabled' => false
                        ],
                        'showInLegend' => true
                    ]
                ],
                'series' => [
                    [
                        'type' => 'pie',
                        'name' => 'Percentage',
                        'data' => $fee_column_data,
                    ]],
                'credits' => ['enabled' => false],
            ]
        ]);
        ?>
        </div>
    </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>

        <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">ALLOCATION BY GENDER</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>

              </div>
            </div>
              <div class="box-body">
        <div class="chart">
            <?php
              $column_data = [[0 => 'Male Applicants Allocated ( '.number_format($male_applicants).' )', 1 => doubleval($male_applicants)], [0 => 'Female Applicants Allocated( '.number_format($female_applicants).' )', 1 => doubleval($female_applicants)]];
        echo Highcharts::widget([
            'options' => [
                'chart' => ['type' => 'pie', 'height' => '295', 'plotBackgroundColor' => null,
                    'plotBorderWidth' => null,
                    'plotShadow' => false],
                'title' => ['text' => ''],
                'tooltip' => [
                    'pointFormat' => '{series.name}:
                        <b>{point.percentage:.1f}%</b>'
                ],
                'plotOptions' => [
                    'pie' => [
                        'allowPointSelect' => true,
                        'cursor' => 'pointer',
                        'dataLabels' => [
                            'enabled' => false
                        ],
                        'showInLegend' => true
                    ]
                ],
                'series' => [
                    [
                        'type' => 'pie',
                        'name' => 'Percentage',
                        'data' => $column_data,
                    ]],
                'credits' => ['enabled' => false],
            ]
        ]);
        ?>
        </div>
    </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
    </div>
    
      
<!-- FOURTH ROW GRAPHICAL DATA -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= number_format($applicants_verified);?></h3>

              <p># of Verified Applicants</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
     
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= number_format($undergraduate_applications);?></h3>

              <p># of undergraduate applicants allocated</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= number_format($diploma_applications);?></h3>

              <p># of diploma applicants allocated</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3><?= number_format($postgraduate_applications);?></h3>

              <p># of postgraduate applicants allocated</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
     
          </div>
        </div>
        <!-- ./col -->
      </div>
  </section>
</div>
</div>

