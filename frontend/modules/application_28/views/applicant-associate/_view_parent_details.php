  <table id="example2" class="table table-bordered table-hover">
            
                    <tbody>
                   <?php  
                           $sex=$model->sex;
                            if($sex=="M"){
                            $position="father "  ;       
                            }
                            else{
                            $position="mother "  ;  
                            }
                 echo "<tr>
                        <td width='300px'><b>Is your $position alive ?</b></td>
                        <td>".$model->is_parent_alive."</td>
                      </tr>";
                       if($model->is_parent_alive=="NO"){
                      echo "<tr>
                                <td colspan='2'><b>Death Certificate Document</b> </td>
                                
                              </tr>";
                                echo '<tr><td colspan="2">
           <iframe src="'.$model->death_certificate_document.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                       }
                        if($model->is_parent_alive=="YES"){
                         echo "<tr>
                        <td width='300px'><b>Is your $position Disabled ?</b></td>
                        <td>".$model->disability_status."</td>
                      </tr>";
                       if($model->disability_status=="YES"&&$model->is_parent_alive=="YES"){
                      echo "<tr>
                                <td colspan='2'><b>Disability Document</b></td>
                                 
                              </tr>";
                        echo '<tr><td colspan="2">
           <iframe src="'.$model->disability_document.'" style="width:900px;height:300px;" frameborder="0"></iframe>
                            </td></tr>';
                       }
                        }
                      ?>
                    </tbody>
                    
                  </table> 