<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/11/18
 * Time: 8:16 AM
 */
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/13/18
 * Time: 3:41 PM
 */
use backend\modules\application\controllers\FormStorageController;
//ini_set('max_execution_time','123456');
ini_set('max_execution_time','-1');

ini_set('memory_limit', '-1');
?>
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon bg-blue"><span class="fa fa-search"></span></div>
                <input type="text"  style="height: auto; font-size: 20px;" class="form-control" id="searchIndex" placeholder="Search index Number e.g. S0108.0110.2004" />
                <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearSearchIndex"><span class="fa fa-magic"></span> Clear</button></div>

            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon bg-blue"><span class="fa fa-search"></span></div>
                <input type="text" class="form-control"  style="height: auto; font-size: 20px;" id="formNumber" placeholder="Search Form Number" />
                <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearFormNumber"><span class="fa fa-magic"></span> Clear</button></div>
            </div>
        </div>
    </div>

    <div class="col-md-1"><button type="button" class="btn btn-primary" id="btnSearch"><b class="fa fa-search"></b> Search</button></div>
    <div class="col-md-1 pull-right"><a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/mobile')?>" class="btn btn-bitbucket btn-primary"><i class="fa fa-mobile-phone"></i> Mobile Mode</a>
    </div>
</div>

<script>
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
        return val;
    }
    // $(function () {
    function SearchFolder(){
        $("#results_preview").html("<tr><td style='font-size: large;' colspan='5'><span class='fa fa-spinner fa-spin fa-3x'></span> Please Wait...</td></tr>");
        var indexNumber =$("#searchIndex").val();
        var formNumber =$("#formNumber").val();
        $.ajax({
            url:"<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/retrieving'); ?>",
            type:"POST",
            cache:false,
            data:{
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>',
                indexNumber:indexNumber,
                formNumber:formNumber,

            },
            success:function (data) {
                console.log(data);
                $("#results_preview").html("");
                var limit = data.folder_limit*1;

                if (data!==''){
                    var counter = 0;
                    $.each(data,function (index,object) {
                        counter++;
                        var sequence = 'N/A';
                        if (object.storage_sequence!==0){
                            sequence = commaSeparateNumber((object.storage_sequence*1));
                        }
                        $("#results_preview").append('' +
                            '<tr style="font-size: large;">' +
                            '<td>'+counter+'</td>' +
                            '<td>'+object.form_four_index_number+'</td>' +
                            '<td>'+object.applicant_name+'</td>' +
                            '<td>'+object.form_number+'</td>' +
                            '<td>'+object.folder_number+'</td>' +
                            '<td>'+sequence+'</td>' +
                            '<td>'+object.remarks+'</td>' +
                            '<td><button type="button" class="btn btn-primary"><b class="fa fa-eye"></b> Preview</button></td>' +
                            '</tr>'
                        );

                        //JsBarcode("#code"+object.folderID,object.output);
                        /* JsBarcode("#code"+object.folderID,object.output, {
                             //format: "pharmacode",
                             lineColor: "#000",
                             width: 4,
                             height: 20,
                             displayValue: true
                         });*/
                     /*   JsBarcode("#code"+object.folderID,object.output, {
                            //format: "pharmacode",
                            lineColor: "#000",
                            width: 4,
                            height: 18,
                            displayValue: true
                        });*/

                    });






                }else{
                    $("#results_preview").html("<tr class='text-danger'><td colspan='5' style='font-size: large;'><span class='fa fa-ban fa-3x'></span> Records Not Found!</td></tr>");
                }
            }


        });

    }
    $(document).ready(function () {
       /* $("#btnSearch").on("click",function () {
            SearchFolder();
        });*/

        $("#clearSearchIndex").on("click",function () {
            $("#searchIndex").val("");
        });

        $("#clearFormNumber").on("click",function () {
            $("#formNumber").val("");
        });

        $("#searchIndex").on("change",function () {
            //'19U2018', 'S3571.0008.2011', NULL, 'EMMANUEL PAULO ANDREA', '19U2018', '7', '2018-000001', '120'

            SearchFolder();

        });

        $("#formNumber").on("change",function () {
            SearchFolder();

        });
    });



</script>