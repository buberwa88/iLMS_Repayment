
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  ///$model=  common\models\Content::findOne(["title"=>'home','status'=>1]);
?>
<style>
* {
    box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
    float: left;
    width: 50%;
    padding: 10px;
    height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}
</style>
<?php //= $model->description?>

<!doctype html>
 <article>
    <div>
<div style="font-size: 15px; font-family: Helvetica;">
	<p>
		Welcome to the Online Loan Application System. Only Tanzanian Nationals are invited to apply to higher education loans.
	</p>
	<p>
		The <strong>Loan Application Cycle</strong> for <strong>2018/2019 </strong>academic year will be open from <strong>10<sup>th</sup> May, 2018</strong> through <strong>15<sup>th</sup> July, 2018</strong>.
	</p>
	<p>
		All applicants are advised to read carefully the <strong> guidelines and criteria for issuance of students' loans and grants for the 2018/2019 academic year (Mwongozo wa utoaji mikopo na ruzuku kwa wanafunzi kwa mwaka wa masomo 2018/19)</strong>.
	</p>
        <p style='text-color:red'>
     <a style='color:red' href="index.php?r=application/default/guideline-swahili"> PAKUA MWONGOZO WA UTOAJI MIKOPO NA RUZUKU </a>  
	</p>
      <p style='style:text-color:red'>
     <a style='color:red' href="index.php?r=application/default/guideline-english">DOWNLOAD GUIDELINES AND CRITERIA FOR ISSUANCE OF STUDENTS’ LOANS AND GRANTS</a>  
	</p>
        
        <p>
		In order to use the system easily; it is recommended that applicants should read all the instructions placed under <strong>Instructions link</strong>.
	</p>
	
	<p>
	&#39&#39In case of any difficulties when using the system; applicants can always <strong>refer back to instructions</strong> or call <strong>HESLB Helpdesk</strong> through<br/> <strong>number +255 22 550 7910 </strong>between <strong>8.00am</strong> to <strong>8.00pm</strong> from <strong>Monday </strong>to<strong> Friday</strong> and on <strong>Saturdays</strong> from <strong>8.00am</strong> to <strong>4.00pm.</strong>&nbsp;
	</p>
	<?php 
	 $sqlquest=Yii::$app->db->createCommand('SELECT count(*) FROM `application_cycle` apc join academic_year ac  on apc.`academic_year_id`=ac.`academic_year_id` WHERE application_cycle_status_out_id=2 AND ac.`academic_year_id`=1')->queryScalar();
	if($sqlquest==0){
	?>
	<div class="row" style="margin:0px;margin-top: 30px;">
		<div class="column">
			<p style="margin:0px;font-size:16px;">
				If you are not registered yet;
			</p>
			<p>
				<strong>
					<a href="/index.php?r=application/default/loan-apply">
						<button type="button" class="btn btn-primary btn-sm" style="width:80%;font-size:16px;">
							REGISTER
						</button>
					</a>
				</strong>
			</p>
		</div>
		<div class="column">
			<p style="margin:0px;font-size:16px;">
				If you are registered already and want to login;
			</p>
			<p>
				<strong>
					<a href="/index.php?r=application/default/home-page&amp;activeTab=login_tab_id">
						<button type="button" class="btn btn-primary btn-sm" style="width:80%;font-size:16px;background-color: #00C0EF;">
							LOGIN
						</button>
					</a>
				</strong>
			</p>
		</div>
	</div>
	<?php }else{
$openedForCorrections=Yii::$app->db->createCommand('SELECT count(*) FROM `reattachment_setting` WHERE is_active=1')->queryScalar();
if($openedForCorrections==0){
	?>
   <div class="alert alert-warning alert-dismissible">
               
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <h2>The Application is Currently Closed.</h2>
              </div>	
	<?php }else{
	?>
	<div class="alert alert-info alert-dismissible">
               
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                <h2><p>The window is now open for corrections from 24<sup>th</sup>-30<sup>th</sup> September,2018.</p></h2>
              </div>
			  <p style='text-color:red'>
     <a style='color:red' href="https://www.heslb.go.tz/list_of_applicants_with_missing_informations/" target="_blank"> ANGALIA ORODHA YA WAOMBAJI AMBAO FOMU ZAO ZA MAOMBI ZINA UPUNGUFU</a> 
	</p>
	<?php
	}}?>
</div>
    </div>
</article>

