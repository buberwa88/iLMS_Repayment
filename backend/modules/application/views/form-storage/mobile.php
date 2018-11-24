<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/20/18
 * Time: 9:57 AM
 */
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/JsBarcode.all.min.js"></script>

<div class="col-lg-6">
    <div class="panel" id="Panel">
        <div class="panel-heading" id="pHhead">
            <div class="row">
                <div class="col-md-6 pull-left"><a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/retrieving')?>" class="btn btn-xl btn-primary"><i class="fa fa-desktop"></i> Back to PC mode</a></div>
                <div class="col-md-6 pull-right"><a href="<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/mobile')?>" class="btn  btn-xl btn-primary"><i class="fa fa-refresh"></i> Reset</a></div>

            </div>

                    <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon bg-blue"><span class="fa fa-keyboard-o"></span></div>
                    <input type="text"  style="height: auto; font-size: 20px;" class="form-control" id="searchIndex" placeholder="Index Number e.g. S0108.0110.2004" />
                    <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearSearchIndex"><span class="fa fa-magic"></span> Clear</button></div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon bg-blue"><span class="fa fa-keyboard-o"></span></div>
                    <input type="text" class="form-control"  style="height: auto; font-size: 20px;" id="formNumber" placeholder="Form Number" />
                    <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearFormNumber"><span class="fa fa-magic"></span> Clear</button></div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon bg-blue"><span class="fa fa-search"></span></div>
                    <input type="text" class="form-control"  style="height: auto; font-size: 20px;" id="folderNumber" placeholder="Search Folder Number" />
                    <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearFolderNumber"><span class="fa fa-magic"></span> Clear</button></div>
                </div>
            </div>
        </div>
        <div class="panel-body" id="pBody">
<br />
<br />
<br />
<br />
<br />
<br />
        </div>
        <div class="panel-footer" id="pFooter">

        </div>
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
        $("#pBody").html("<div style='font-size: xx-large;'><span class='fa fa-spinner fa-spin fa-5x'></span> <p>Please Wait...</p></div>");
        var indexNumber =$("#searchIndex").val();
        var formNumber =$("#formNumber").val();
        var folderNumber =$("#folderNumber").val();
        $("#pBody").attr('class','panel-body');
        $("#Panel").attr('class','panel');
        $.ajax({
            url:"<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/mobile'); ?>",
            type:"POST",
            cache:false,
            data:{
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>',
                indexNumber:indexNumber,
                formNumber:formNumber,
                folderNumber:folderNumber,

            },
            success:function (data) {
                //console.log(data);
                $("#pBody").html("");


                if (data.length!==0){
                    var counter = 0;
                    $("#pBody").attr('class','panel-body bg-green');
                    $("#Panel").attr('class','panel bg-green');
                    $("#pBody").html("<div style='font-size: xx-large; text-align: center;'><div class='fa fa-check fa-5x'></div> <p>Record Found!</p></div>");

                    $("#folderNumber").val(data[0].folder_number);
                    $("#folderNumber").focus();
                }else{

                    $("#pBody").attr('class','panel-body bg-red');
                    $("#Panel").attr('class','panel bg-red');
                    $("#pBody").html("<div style='font-size: xx-large; text-align: center;'><div class='fa fa-ban fa-5x'></div> <p>Record NOT Found!</p></div>");
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
            $("#folderNumber").focus();
        });

        $("#clearFormNumber").on("click",function () {
            $("#formNumber").val("");
            $("#folderNumber").focus();
        });

        $("#clearFolderNumber").on("click",function () {
            $("#folderNumber").val("");
            $("#pBody").attr('class','panel-body');
            $("#folderNumber").focus();
        });

        $("#searchIndex").on("change",function () {
            //'19U2018', 'S3571.0008.2011', NULL, 'EMMANUEL PAULO ANDREA', '19U2018', '7', '2018-000001', '120'

            SearchFolder();
            $("#folderNumber").focus();
        });

        $("#formNumber").on("change",function () {
            SearchFolder();
            $("#folderNumber").focus();

        });
        $("#folderNumber").on("change",function () {
            SearchFolder();
            $("#folderNumber").focus();

        });
    });



</script>