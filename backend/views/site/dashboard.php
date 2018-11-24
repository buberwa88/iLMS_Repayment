<?php
/* @var $this yii\web\View */
/* @var $model app\models\Country */

$this->title = 'Dashboard';
//$this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['dashboard']];
$this->params['breadcrumbs'][] = $this->title;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
    $year=2015;
?>
 
             
               <div class="scoping-update">
<div class="box">
                <div class="box-header">
               
                </div><!-- /.box-header -->
                <div class="box-body">
                  
           <div class="table-responsive">
         
                <div class="box-body">
          
                    <div class="col-xs-5">
                        <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th colspan="3">Church Believers</th>
                        
                      </tr>
                      <tr>
                        <th># Male</th>
                        <th># Female</th>
                        <th># Children</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                            $male = Yii::$app->db->createCommand("SELECT count(*) FROM viz_members_tbl where gender='Male'")->queryScalar();           
                            $female = Yii::$app->db->createCommand("SELECT count(*) FROM viz_members_tbl where gender='Female'")->queryScalar();   
                            $child = Yii::$app->db->createCommand("SELECT count(*) FROM children_tbl")->queryScalar();   
                            
                           //$casemi[]=[["Male"=>78],["Female"=>$female],["Children"=>$child]];
                           $casemi[]=array("Male",intval($male));
                           $casemi[]=array("Female",intval($female));
                           $casemi[]=array("Children",intval($child));
                      echo "<tr>
                        <td>".$male."</td>
                        <td>".$female."</td>
                        <td>".$child."</td>
                      </tr>";
                      
                       ?>
                    </tbody>
                    
                  </table>
                   
                    </div>
                       <div class="col-xs-7">
                               <?= Highcharts::widget([
    'scripts' => [
        'highcharts-3d',
        'modules/exporting',
        'themes/sand-signika',
    ],
    'options' => [
        'credits' => ['enabled' => false],
        'chart' => ['type' => 'pie',
            'options3d' => ['enabled' => true,
                'alpha' => 55, //adjust for tilt
                'beta' => 0, // adjust for turn
            ]
        ],
        'plotOptions' => [ // it is important here is code for change depth and use pie as donut
            'pie' => [
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'innerSize' =>0,
                'depth' => 45,
                'dataLabels'=>[
                     'enabled'=> true,
                     'format'=> '<b>{point.name}</b>: {point.percentage:.1f} %',
                     'style'=>[
                       'color'=>"(Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black' ", 
                     ]
                ],
            ]
        
        ],
        'title' => ['text' => 'Church Believers'],
        'series' => [[// mind the [[ instead of [
            'type' => 'pie',
            'name' => 'Total',
            'data' =>$casemi,  
            ]], //mind the ]] instead of ] 
    ]
]); ?>
         
                    </div>
                    <div class="space10"></div>
                     <div class="col-xs-12">
                        <table id="example2" class="table table-bordered table-hover">
                    <thead>
                         <tr>
                            <th colspan="7">General Offering <?=$year?></th>
                        
                      <tr>
                     <td class="totals cost"><b>Month</b></td>
                    <td class="totals cost">JANUARY</td>
                    <td class="totals cost">FEBRUARY</td>
                    <td class="totals cost">MARCH</td>
                    
                    <td class="totals cost">APRIL</td>
                    <td class="totals cost">MAY</td>
                    <td class="totals cost">JUNE</td>
                    
                    <td class="totals cost">JULY</td>
                    <td class="totals cost">AUGOST</td>
                    <td class="totals cost">SEPTEMBER</td>
                    <td class="totals">OCTOBER</td>
                    <td class="totals cost">NOVEMBER</td>
                    <td class="totals cost">DECEMBER</td>
                  
                </tr>
                    </thead>
                    <tbody>
                   <?php
                      function getgeneral($monthy,$year){
                    $startdate=date("$year-$monthy-0");
                    $enddate=date("$year-$monthy-32");
                    //echo "SELECT count(*) FROM viz_general_offer_tbls WHERE  date between '{$startdate}' AND '{$enddate}'";
                    //exit();
          
                 $data = Yii::$app->db->createCommand("SELECT SUM(amount) as amount FROM viz_general_offer_tbls WHERE  date between '{$startdate}' AND '{$enddate}'")->queryAll();
               if(count($data)>0){
                   foreach ($data as $datas);  
                     $amount=$datas["amount"];
               }
               else{
                $amount=0;     
               }
              return  $amount;
                       }
                   
                echo '<tr>
                       <td class="totals cost"><b>Amount</b></td>
                      <td class="totals cost">'.getgeneral('01',$year).'</td>
                      <td class="totals cost">'.getgeneral('02',$year).'</td>
                      <td class="totals  cost">'.getgeneral('03',$year).'</td>
                      <td class="totals cost">'.getgeneral('04',$year).'</td>
                      <td class="totals cost">'.getgeneral('05',$year).'</td>
                      <td class="totals cost">'.getgeneral('06',$year).'</td>
                      <td class="totals  cost">'.getgeneral('07',$year).'</td>
                      <td class="totals cost">'.getgeneral('08',$year).'</td>
                      <td class="totals cost">'.getgeneral('09',$year).'</td>
                      <td class="totals cost">'.getgeneral(10,$year).'</td>
                      <td class="totals cost">'.getgeneral(11,$year).'</td>
                      <td class="totals cost">'.getgeneral(12,$year).'</td>
                </tr>';
                   
                   ?>
                       
                    </tbody>
                  
                  </table>
                   
                        <?php
               //$data1=[2, 2, 1, 0, 4,2,2,4,7,2,2,4];
                  for($ii=1;$ii<=12;$ii++){
                        if($ii<10){
                         $ix="0".$ii;   
                        }
                        else{
                       $ix=$ii;       
                        }
         $datageneral=intval(getgeneral($ix,$year));
         $graphgeneral[]=$datageneral;
         $datamonth[]=date("F", mktime(0, 0, 0, $ii, 10));
     }
           //echo "</br>";
           //print_r($inprogressdata);
              echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    'options' => [
        'title' => [
            'text' => 'General offering by Month',
        ],
      
        'xAxis' => [
            'categories' => $datamonth,
        ],
    
        'series' => [
             [
                'type' => 'column',
                'name' => 'Amount',
                'data' => $graphgeneral,
            ],
          
        ],
    ]
]);
              
             
            ?>
                    
                         <div class="space10"></div>
                    
                        <table id="example2" class="table table-bordered table-hover">
                    <thead>
                         <tr>
                             <th colspan="2">Individual Offering <?=$year?></th>
                      </tr>
                          <tr>
                      <td class="totals cost"><b>Month</b></td>
                    <td class="totals cost">JANUARY</td>
                    <td class="totals cost">FEBRUARY</td>
                    <td class="totals cost">MARCH</td>
                    
                    <td class="totals cost">APRIL</td>
                    <td class="totals cost">MAY</td>
                    <td class="totals cost">JUNE</td>
                    
                    <td class="totals cost">JULY</td>
                    <td class="totals cost">AUGOST</td>
                    <td class="totals cost">SEPTEMBER</td>
                    <td class="totals">OCTOBER</td>
                    <td class="totals cost">NOVEMBER</td>
                    <td class="totals cost">DECEMBER</td>
                  
                </tr>
                    </thead>
                    <tbody>
                   <?php
                      function getofferingind($monthy,$year){
                    $startdate=date("$year-$monthy-0");
                    $enddate=date("$year-$monthy-32");
                    //echo "SELECT count(*) FROM viz_general_offer_tbls WHERE  date between '{$startdate}' AND '{$enddate}'";
                    //exit();
              $data = Yii::$app->db->createCommand("SELECT SUM(amount) as amount FROM viz_giving WHERE  date between '{$startdate}' AND '{$enddate}'")->queryAll();
               if(count($data)>0){
                   foreach ($data as $datas);  
                     $amount=$datas["amount"];
               }
               else{
                $amount=0;     
               }
              return  $amount;
                       }
                     
                echo '<tr>
                      <td class="totals cost"><b>Amount</b></td>
                      <td class="totals cost">'.getofferingind('01',$year).'</td>
                      <td class="totals cost">'.getofferingind('02',$year).'</td>
                      <td class="totals  cost">'.getofferingind('03',$year).'</td>
                      <td class="totals cost">'.getofferingind('04',$year).'</td>
                      <td class="totals cost">'.getofferingind('05',$year).'</td>
                      <td class="totals cost">'.getofferingind('06',$year).'</td>
                      <td class="totals  cost">'.getofferingind('07',$year).'</td>
                      <td class="totals cost">'.getofferingind('08',$year).'</td>
                      <td class="totals cost">'.getofferingind('09',$year).'</td>
                      <td class="totals cost">'.getofferingind(10,$year).'</td>
                      <td class="totals cost">'.getofferingind(11,$year).'</td>
                      <td class="totals cost">'.getofferingind(12,$year).'</td>
                </tr>';
                   
                   ?>
                    </thead>
                    <tbody>
                    
                  </table>
                         
                    </div>
                    <div class="col-xs-12">
                        <?php
                    for($ii=1;$ii<=12;$ii++){
                        if($ii<10){
                         $ix="0".$ii;   
                        }
                        else{
                       $ix=$ii;       
                        }
                    $dataind=intval(getofferingind($ix,$year));
                    $dataofferingi[]=$dataind;
                    $datamonth[]=date("F", mktime(0, 0, 0, $ii, 10));
                }
              echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/grid-light',
    ],
    'options' => [
        'title' => [
            'text' => 'Individual Offering by Month',
        ],
        'xAxis' => [
            'categories' =>$datamonth,
        ],
    
        'series' => [
             [
                'type' => 'column',
                'name' => 'Amount',
                'data' =>  $dataofferingi,
            ],
          
        ],
    ]
]);
              
             
            ?>
                       
                    </div>
                  
                </div><!-- /.box-body -->
           </div>
                </div>
</div>
               </div>