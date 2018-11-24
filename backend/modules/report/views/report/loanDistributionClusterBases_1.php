<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;
$stle_header='style="border: 1px solid #000000; border-collapse: collapse;\"';
$stle_headerNumb='style="border: 1px solid #000000; border-collapse: collapse;text-align: right;\"';
$stleTitle='style="font-weight:bold;width:100%;\"';

echo $this->render('report_header',['reportName'=>$reportName]);
?>
<table width="100%" <?php echo $stle_header; ?>>
<?php 
   $totalPercent1=0;
   $count=0;  
   $rowNo=0;
   $grandTotalStudents=0;
   $totalPercentF2=0;
   $Grandsex_mG=0;
   $Grandsex_fG=0;
   $Grandsex_oG=0;
   $Grandsex_mPvt=0;
   $Grandsex_fPvt=0;
   $Grandsex_oP=0;
   $grandTotalPercent=0;
   $totalStudentsPerCluster=0;
   $Grandsex_mGsUBtotal=0;
   $Grandsex_fGsUBtotal=0;
   $Grandsex_oGsUBtotal=0;
   $Grandsex_mPvtsUBtotal=0;
   $Grandsex_fPvtsUBtotal=0;
   $Grandsex_oPsUBtotal=0;
   
   foreach($reportData as $row){
?>

<?php
$cluster_definition_idHead=$row['cluster_definition_id'];

$resultCount=Report::getCountClusters($cluster_definition_idHead);
if($count==0){
    $academicYear=1;
    $clusterDefPercent=Report::getAllocationPlanClusterSetting($cluster_definition_idHead);
    $publicPrivateDistr=Report::getPublicPrivateDistrubution($academicYear);
    foreach($publicPrivateDistr as $privatPublicD){
        $institution_type=$privatPublicD['institution_type'];
    if($institution_type==0){
      $publicDist=$privatPublicD['publicPrivateDistr'];  
    }
    
    if($institution_type==1){
      $privateDist=$privatPublicD['publicPrivateDistr'];  
    }
    }
    $privatPublicGender=Report::getGetPrivatePublicGenderDistr($academicYear);
?>

                    <thead>
                        <tr>
                            <th style="text-align: left; " <?php echo $stle_header; ?> colspan="10">LOAN DISTRIBUTION BASED ON <?php echo $clusterDefPercent['student_percentage_distribution']; ?>%</th>
                        </tr>
                        <tr>
                            <th style="text-align: left; " ></th>
                            <th style="text-align: left; " colspan="3" <?php echo $stle_header; ?>></th>
                            <th style="text-align: left; " colspan="3" <?php echo $stle_header; ?>>PUBLIC (<?php echo $publicDist; ?>%)</th>
                            <th style="text-align: left; " colspan="3" <?php echo $stle_header; ?>>PRIVATE (<?php echo $privateDist; ?>%)</th>
                        </tr>
                        <tr>
                            <th style="text-align: left; "></th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>COURSE STATUS</th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>%</th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>STUDENTS</th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>MALE(<?php echo $privatPublicGender['male_percentage']; ?>%)</th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>FEMALE(<?php echo $privatPublicGender['female_percentage']; ?>%)</th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>OTHER(%)</th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>MALE(<?php echo $privatPublicGender['male_percentage']; ?>%)</th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>FEMALE(<?php echo $privatPublicGender['female_percentage']; ?>%)</th>
                            <th style="text-align: left; " <?php echo $stle_header; ?>>OTHER(%)</th> 
                        </tr>
                    </thead>
                    <?php
}
                    ?>
                    <tbody>
                        
       <?php
   
      
       //GET TOTAL STUDENTS
       $params = array(
                    ':cluster_definition_id' => $row['cluster_definition_id'],
                    ':programme_category_id' => $row['programme_category_id'],
//                    ':academic_year_id' => $row['academic_year_id'],
//                    ':allocation_type' => $row['allocation_type'],
//                    ':study_year' => $row['study_year']
                );       
       $sub_query_items = Report::getSubQueryItemsByRowId($reportSubQuery, $params);
                    if (count($sub_query_items) > 0) {
                        foreach ($sub_query_items as $sub_query_item) {                            
                                $totalStudents = $sub_query_item['students'];                            
                        }
                    }else{
                       $totalStudents=0; 
                    }
                 $cluster_definition_id=$row['cluster_definition_id'];
                 $academicYear=$row['academic_year_id'];
                 $batchNumber=$row['allocation_batch_id'];
                
       $sub_query_itemsClusterCount = Report::getCountPerCluster($cluster_definition_id,$academicYear,$batchNumber);
       $totalCountStudentsPerCluster=$sub_query_itemsClusterCount['totalStudentsPerCluster'];         
       
       
                    //echo $totalStudents;
      //exit;
       //END FOR TOTAL STUDENTS     
           ?>       
              
                        <tr >
                            <td style="width: 65px; "><?php if($count==0){ echo $row['cluster_name']; } ?></td>
                            <td <?php echo $stle_header; ?>><?php echo $row['programme_category_name']; ?></td> 
                            <td <?php echo $stle_headerNumb; ?>><?php
                            //$totalPercentF=$totalPercent.$row['cluster_name'];
                            $totalPercentF=number_format((($sub_query_item['students']/$totalCountStudentsPerCluster)*100),2);
                            $totalPercentF2 +=$totalPercentF;                            
                            //$totalPercent1 +=$totalPercentF;
                            echo $totalPercentF; ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($sub_query_item['students']); ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($sub_query_item['sex_mG']); ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($sub_query_item['sex_fG']); ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($sub_query_item['sex_oG']); ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($sub_query_item['sex_mPvt']); ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($sub_query_item['sex_fPvt']); ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($sub_query_item['sex_oP']); ?></td>
                        </tr>                        
                <?php 
                $count++;
                $rowNo++;
                //here is fo subtotal per cluster
                $totalStudentsPerCluster +=$sub_query_item['students'];
                $Grandsex_mGsUBtotal +=$sub_query_item['sex_mG'];
              $Grandsex_fGsUBtotal +=$sub_query_item['sex_fG'];
              $Grandsex_oGsUBtotal +=$sub_query_item['sex_oG'];
              $Grandsex_mPvtsUBtotal +=$sub_query_item['sex_mPvt'];
              $Grandsex_fPvtsUBtotal +=$sub_query_item['sex_fPvt'];
              $Grandsex_oPsUBtotal +=$sub_query_item['sex_oP'];
                //end for sub total per cluster
                
                //thisi is for Grand Total
                $grandTotalStudents +=$sub_query_item['students'];
                $Grandsex_mG +=$sub_query_item['sex_mG'];
              $Grandsex_fG +=$sub_query_item['sex_fG'];
              $Grandsex_oG +=$sub_query_item['sex_oG'];
              $Grandsex_mPvt +=$sub_query_item['sex_mPvt'];
              $Grandsex_fPvt +=$sub_query_item['sex_fPvt'];
              $Grandsex_oP +=$sub_query_item['sex_oP'];
              //end for grand total
                //if($count==$resultCount){
                //$count=0;    
                //}
                ?>
          <?php if($count==$resultCount){ 
              $countClusters=3;
              
              
              $grandTotalPercent +=$totalPercentF2;
                        ?>
                        <tr >
                            <td ></td>
                            <td <?php echo $stle_header; ?>><strong>Sub Total</strong></td>
                            <td <?php echo $stle_headerNumb; ?>><?php
                            //$totalPercentF=$totalPercent.$row['cluster_name'];
                            
                            //$totalPercent1 +=$totalPercentF;
                            echo $totalPercentF2; ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($totalStudentsPerCluster); ?></td>
                            <td <?php echo $stle_headerNumb; ?>  ><?php echo number_format($Grandsex_mGsUBtotal); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_fGsUBtotal); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_oGsUBtotal); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_mPvtsUBtotal); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_fPvtsUBtotal); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_oPsUBtotal); ?></td>
                        </tr>
                        <?php
                        
                        $count=0;
                        $totalPercentF2=0;
                        $totalStudentsPerCluster=0;
                        $Grandsex_mGsUBtotal=0;
                        $Grandsex_fGsUBtotal=0;
                        $Grandsex_oGsUBtotal=0;
                        $Grandsex_mPvtsUBtotal=0;
                        $Grandsex_fPvtsUBtotal=0;
                        $Grandsex_oPsUBtotal=0;
                        } 
                        ?>      
                
    <?php                    
   } ?>  
                        
                        <tr>
                            <th style="text-align: left; " <?php echo $stle_header; ?> colspan="10">Grand Total</th>
                        </tr>
                        <tr >
                            <td ></td>
                            <td <?php echo $stle_header; ?>><strong>Grand Total</strong></td>
                            <td <?php echo $stle_headerNumb; ?>><?php
                            //$totalPercentF=$totalPercent.$row['cluster_name'];
                            
                            //$totalPercent1 +=$totalPercentF;
                            echo number_format($grandTotalPercent/$countClusters); ?></td>
                            <td <?php echo $stle_headerNumb; ?>><?php echo number_format($grandTotalStudents); ?></td>
                            <td <?php echo $stle_headerNumb; ?>  ><?php echo number_format($Grandsex_mG); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_fG); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_oG); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_mPvt); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_fPvt); ?></td>
                            <td <?php echo $stle_headerNumb; ?> ><?php echo number_format($Grandsex_oP); ?></td>
                        </tr>
                        
                    </tbody>
                </table>