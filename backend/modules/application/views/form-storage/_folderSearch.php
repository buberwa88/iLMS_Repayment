<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/13/18
 * Time: 3:41 PM
 */
use backend\modules\application\controllers\FormStorageController;
?>
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon bg-blue"><span class="fa fa-search"></span></div>
                <input type="number" min="1900" style="height: auto; font-size: 20px;" class="form-control" id="searchYear" placeholder="Search year e.g. <?php echo date('Y'); ?>" />
                <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearSearchYear"><span class="fa fa-magic"></span> Clear</button></div>

            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="form-group">
            <div class="input-group">

                <div class="input-group-addon bg-blue"><span class="fa fa-search"></span></div>
                <input type="text" class="form-control"  style="height: auto; font-size: 20px;" id="searchFolder" placeholder="Search Form Number e.g. <?php echo FormStorageController::NumberGenerator(); ?>" />
                <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearSearchFolder"><span class="fa fa-magic"></span> Clear</button></div>
            </div>
        </div>
    </div>

    <div class="col-md-1 pull-right"><button type="button" class="btn btn-primary" id="btnSearch"><b class="fa fa-search"></b> Search</button></div>
</div>

<script>

</script>
