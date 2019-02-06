<script>
    function setRefundType(type) {
        //alert(type);
        if (type == 'NONBENEFICIARY') {
            document.getElementById("nonbeneficiary").style.display = "block";
            document.getElementById("overdeducted").style.display = "none";
            document.getElementById("deceased").style.display = "none";
        }else if (type == 'OVERDEDUCTED') {
            document.getElementById("overdeducted").style.display = "block";
            document.getElementById("nonbeneficiary").style.display = "none";
            document.getElementById("deceased").style.display = "none";

        }else if (type == 'DECEASED') {
            document.getElementById("deceased").style.display = "block";
            document.getElementById("overdeducted").style.display = "none";
            document.getElementById("nonbeneficiary").style.display = "none";

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
        <div class="panel-heading">
            <em>
       <?= Html::encode($this->title) ?>
                </em>
        </div>
        <div class="panel-body">
            <div class="col-lg-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <center>
                            <label class="radio-inline"><button type="button"  class="btn btn-block btn-primary btn-lg" name="Education[is_necta]" onclick="setRefundType('NONBENEFICIARY')" value="1" <?php echo $nonbeneficiary; ?> >NON-BENEFICIARY</label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel panel-info">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <center>
                            <label class="radio-inline"><button type="button" class="btn btn-block btn-warning btn-lg" name="Education[is_necta]" onclick="setRefundType('OVERDEDUCTED')" value="2" <?php echo $overdeducted; ?> >OVER-DEDUCTED</label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="panel panel-info">
                    <div class="panel-heading">

                    </div>
                    <div class="panel-body">
                        <center>
                            <label class="radio-inline"><button type="button" class="btn btn-block btn-success btn-lg" name="Education[is_necta]" onclick="setRefundType('DECEASED')" value="3" <?php echo $deceased; ?> >DECEASED</label>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div style='display:none;' id="nonbeneficiary">
                    <?= $this->render('_form_refund_nonbeneficiary', [
                        'model' => $model,
                    ]) ?>
                </div>
				<div style='display:none;' id="overdeducted">
                    <?= $this->render('_form_refund_overdeducted', [
                        'model' => $model,
                    ]) ?>
                </div>
				<div style='display:none;' id="deceased">
                    <?= $this->render('_form_refund_deceased', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>

        </div>
        </div>
</div>
    




 
