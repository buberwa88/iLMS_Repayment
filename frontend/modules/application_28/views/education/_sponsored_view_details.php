 <table id="example2" class="table table-bordered table-hover">
            
                    <tbody>
                   <?php  
                      $value=$model->under_sponsorship==1?'YES':'NO';
                 echo "<tr>
                        <td colspan='2'><b>Were you sponsored  ?</b>
                        $value</td>
                      </tr>";
                       if($model->under_sponsorship==1){
                      echo "<tr>
                                <td colspan='2'><b>Sponsorship Proof Document  </b></td>
                                 
                              </tr>";?>
                        <tr><td colspan="2">
                                
           <iframe src="<?=$model->sponsor_proof_document?>" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>
            <?php
            }
                    
                      ?>
                    </tbody>
                    
                  </table> 