
<div class="employed-beneficiary-view">
    <?php
    foreach ($beneficiaryApplications as $applications) {
        ?>
    <h4><b>Loan #<?php echo $applications->application_id ?></b></h4>
        <?php
        echo $this->render('_application_loan_summary', ['application' => $applications, 'model' => $model]);
    }
    ?>
</div>
