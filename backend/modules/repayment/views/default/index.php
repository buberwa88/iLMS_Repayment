<?php
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;

$this->title = "Home | iLMS";

//update VRF
\frontend\modules\repayment\models\LoanSummary::updateVRFaccumulatedGeneral();
//END update VRF
?>
<style type="text/css">
    .btn.btn-app{
        min-width:250px;
        min-height:180px;
    }
	.welcome{
	   text-align:center;
	   font-size:30px;
	}
</style>
<section class="content-header">
    <h1 id="header2">
<!--        <small>to the National Database for Climate and Hydrology-(NDCH)</small>-->
    </h1>

</section>
<div class="box box-info">
    <div class="box-body">
    <div class="chart">
               
       <?php
           echo Highcharts::widget([
           'options' => [
           'title' => ['text' => 'Employed Beneficiaries vs Amount Collected to HESLB Per Months'],
           'xAxis' => [
              'categories' => ['Nov-2017','Dec-2017','Jan-2018', 'Feb-2018']
             ],
 
           'series' => [
              [
                'type' => 'column',
                'name' => 'No of Employees',
               'data' => [24,29,27,26],
             ],
           [
               'type' => 'column',
               'name' => 'Amount collected to HESLB...',
               'data' => [48,58,54,52],
           ]
          ]
        ]
     ]);
    ?>
        </div>
        </div>
    </div>
</div>