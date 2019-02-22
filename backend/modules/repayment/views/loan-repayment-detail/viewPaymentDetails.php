<div class="employed-beneficiary-view">
        <?php
        echo $this->render('_beneficiary_items_paid', ['model' => $model]);
    ?>
	<?php
	if($model->loanRepayment->payment_category==1){
        echo $this->render('_gspp_employee_details', ['model' => $model]);
		}
    ?>
	<?php

        echo $this->render('_uploaded_employee_details', ['model' => $model]);

    ?>
</div>