   <?php
   $sql="SELECT * FROM `applicant_question` aq join `applicant_qn_response` aqr on aq.`applicant_question_id`=aqr.`applicant_question_id` join question q on q.`question_id`=aq.`question_id`  join `section_question` sq on sq.`question_id`=q.`question_id` join `qresponse_source` qrs on qrs.`qresponse_source_id`=aqr.`qresponse_source_id` WHERE application_id='{$modelApplication->application_id}' AND applicant_category_section_id=9";
   
    ?>
 <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">Application Question</th>
                      </tr>
                
                    </thead>
                    <tbody>
                       
                   
                        <?php
                       // print_r($dataProvider);
  $sqlquest=Yii::$app->db->createCommand($sql)->queryAll(); 
                        $total=0;
                        $i=1;
                 if(count($sqlquest)>0){
                 foreach ($sqlquest as $rows){
                 echo "<tr>
                        <td>".$i."</td>
                        <td>".$rows["question"]."</td>
                         <td>".getAnswered($rows["source_table"],$rows["source_table_value_field"],$rows["response_id"],$rows["source_table_text_field"])."</td>	
                        <td align='right'></td>
                      </tr>";
              
                 $i++;
                      }
             
                  }
                  else{
            //   echo "<tr><td colspan='2'><font color='red'>Sorry No results found</font></td></tr>";       
                  }
                 function getAnswered($table_name,$column_name,$valueId,$value){
               $sqlquest=Yii::$app->db->createCommand("select * from $table_name where $column_name='{$valueId}'")->queryAll(); 
                  $answered="";
                  if(count($sqlquest)>0){
                       foreach($sqlquest as $row);
                       $answered=$row["$value"];
                   }
                   return $answered;
                  }
                       ?>
                    
                    </tbody>
                    
                  </table>