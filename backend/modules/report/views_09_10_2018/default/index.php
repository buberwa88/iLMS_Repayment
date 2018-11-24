<?php
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use backend\modules\application\models\Application;
use backend\modules\application\models\Applicant;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\BankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$user_id = Yii::$app->user->identity->id;
$modelUser = common\models\User::findone($user_id);
$username=strtoupper($modelUser->firstname).' '.strtoupper($modelUser->middlename).' '.strtoupper($modelUser->surname);

$applicants_who_paid_fee = Application::find()->where(['<>','payment_status',0])->count();
$applicants_not_paid_fee = Application::find()->where(['payment_status' => 0])->count();
$total_fee_collected = ($applicants_who_paid_fee -1) * 30000 + 1500;

$female_applicants = Applicant::find()->where(['sex' => 'F'])->count();
$male_applicants = Applicant::find()->andWhere(['or',
                                        ['sex'=>'M'],    
                                        ['sex'=>NULL]])
                                            ->count();

$submitted_applications = Application::find()->where(['loan_application_form_status' => [3]])->count();
//$submitted_applications = Application::find()->where(['loan_application_form_status' => 2])->count();
//$complete_applications = Application::find()->where(['loan_application_form_status' => 3])->count();
//$incomplete_applications = Application::find()->where(['verification_status' => 2])->count();
$incomplete_applications = Application::find()
                                        ->andWhere(['or',
                                        ['loan_application_form_status'=>0],
                                        ['loan_application_form_status'=>1],
                                        ['loan_application_form_status'=>2],    
                                        ['loan_application_form_status'=>NULL],
                                                    ])
                                        ->count();

$diploma_applications = Application::find()->where(['applicant_category_id' => 3])->count();
$undergraduate_applications = Application::find()->where(['applicant_category_id' => 1])->count();
$postgraduate_applications = Application::find()->where(['applicant_category_id' => [2,4,5]])->count();
$all_applications = Application::find()->count();

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
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total fee collected</span>
              <span class="info-box-number"><?= number_format($total_fee_collected).'/=';?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"></span>

            <div class="info-box-content">
              <span class="info-box-text">Applicants who have paid fee</span>
              <span class="info-box-number"><?= number_format($applicants_who_paid_fee); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Applicants who haven't paid fee</span>
              <span class="info-box-number"><?= number_format($applicants_not_paid_fee); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>

<!-- SECOND ROW GRAPHICAL DATA -->
      <div class="row">
        <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">APPLICATIONS BY FEE STATUS</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>

              </div>
            </div>
              <div class="box-body">
        <div class="chart">
            <?php
              $fee_column_data = [[0 => 'Applicants who have paid Fee( '.number_format($applicants_who_paid_fee).' )', 1 => doubleval($applicants_who_paid_fee)], [0 => 'Applicants who have not paid Fee( '.number_format($applicants_not_paid_fee).' )', 1 => doubleval($applicants_not_paid_fee)]];
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
              <h3 class="box-title">APPLICATIONS BY GENDER</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>

              </div>
            </div>
              <div class="box-body">
        <div class="chart">
            <?php
              $column_data = [[0 => 'Male Applicants( '.number_format($male_applicants).' )', 1 => doubleval($male_applicants)], [0 => 'Female Applicants( '.number_format($female_applicants).' )', 1 => doubleval($female_applicants)]];
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
      
<!-- THIRD ROW GRAPHICAL DATA -->
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
              //$application_status_column_data = [[0 => 'Completed( '.number_format($complete_applications).' )', 1 => doubleval($complete_applications)], [0 => 'Incomplete( '.number_format($incomplete_applications).' )', 1 => doubleval($incomplete_applications)], [0 => 'Submitted( '.number_format($submitted_applications).' )', 1 => doubleval($submitted_applications)]];
              $application_status_column_data = [[0 => 'Incomplete( '.number_format($incomplete_applications).' )', 1 => doubleval($incomplete_applications)], [0 => 'Submitted( '.number_format($submitted_applications).' )', 1 => doubleval($submitted_applications)]];
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
                        'data' => $application_status_column_data,
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
        <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">APPLICATIONS BY CATEGORIES</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart">
            <?php
              $application_categories_column_data = [[0 => 'Undergraduate', 1 => doubleval($undergraduate_applications)], [0 => 'Postgraduate', 1 => doubleval($postgraduate_applications)], [0 => 'Diploma', 1 => doubleval($diploma_applications)]];
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
                        'data' => $application_categories_column_data,
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
        <!-- /.col (RIGHT) -->
      </div>
<!-- FOURTH ROW GRAPHICAL DATA -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= number_format($all_applications);?></h3>

              <p># of created accounts</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= number_format($undergraduate_applications);?></h3>

              <p># of undergraduate applicants</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= number_format($diploma_applications);?></h3>

              <p># of diploma applicants</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= number_format($postgraduate_applications);?></h3>

              <p># of postgraduate applicants</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
  </section>
</div>
</div>