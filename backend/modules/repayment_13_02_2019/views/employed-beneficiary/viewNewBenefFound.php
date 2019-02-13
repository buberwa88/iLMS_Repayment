<div class="employed-beneficiary-view">
        <?php
        echo $this->render('_new_beneficiary_found', ['model' => $model]);
    ?>
	<?php
        echo $this->render('_uploaded_employee_details', ['model' => $model]);
    ?>
</div>