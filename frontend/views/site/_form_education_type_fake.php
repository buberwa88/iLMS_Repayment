<script>
    function setRefundType2(type) {
        //alert(type);
        if (type == 'NECTA') {
            document.getElementById("nectaM").style.display = "block";
            document.getElementById("nonnectaM").style.display = "none";
        }else if (type == 'NONNECTA') {
			document.getElementById("nonnectaM").style.display = "block";
            document.getElementById("nectaM").style.display = "none";            
        }
    }
</script>

<style>
    iframe{
        border: 0;
    }
</style>

<?php
     $incomplete=0;
use yii\helpers\Html;
$this->title ='Application for Refund, Select the Refund Type:';
$this->params['breadcrumbs'][] = 'Refund Application';
?>
<div class="education-create">
        <div class="panel panel-info">
        <div class="panel-body">
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <p><b>NECTA STUDENTS </b>(For Claimants who did their form 4 Examinations in Tanzania) </p>
                        <center>
<label class="radio-inline"><button type="button"  class="btn btn-block btn-primary btn-lg" onclick="setRefundType2('NECTA')" value="1" >NECTA[Completed in Tanzania]</label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <center>
                            <p><b> NON NECTA STUDENTS </b>(For Claimants who did form 4 Examinations overseas) </p>
<label class="radio-inline"><button type="button" class="btn btn-block btn-warning btn-lg" onclick="setRefundType2('NONNECTA')" value="2" >NON - NECTA [Holders of Foreign Certificates]</label>
                        </center>
                    </div>
                </div>
            </div>
			

            <div class="col-lg-12">
                <div style='display:none;' id="nectaM">
                    <?= $this->render('_form_refund_educationnecta', [
                        'model' => $model,
                    ]) ?>
                </div>
				<div style='display:none;' id="nonnectaM">
                    <?= $this->render('_form_refund_educationnonnecta', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>

        </div>
        </div>
</div>