<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/20/18
 * Time: 3:59 PM
 */
use backend\modules\application\controllers\FormStorageController;
//ini_set('max_execution_time','123456');
ini_set('max_execution_time','-1');

ini_set('memory_limit', '-1');
?>
<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon bg-blue"><span class="fa fa-search"></span></div>
                <input type="text"  style="height: auto; font-size: 20px;" class="form-control" id="source" placeholder="Search Source Form Number e.g. <?php echo FormStorageController::NumberGenerator(); ?>" />
                <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearSource"><span class="fa fa-magic"></span> Clear</button></div>
                <input type="hidden" class="form-control" value="0" id="source_limit">
                <input type="hidden" class="form-control" value="0" id="source_contents">
                <input type="hidden" class="form-control" value="0" id="source_folder_id">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon bg-blue"><span class="fa fa-search"></span></div>
                <input type="text" class="form-control"  style="height: auto; font-size: 20px;" id="destination" placeholder="Search Destination Form Number e.g. <?php echo FormStorageController::NumberGenerator(); ?>" />
                <div class="input-group-addon bg-blue"><button class="btn btn-primary" id="clearDestination"><span class="fa fa-magic"></span> Clear</button></div>
            </div>
            <input type="hidden" class="form-control" value="0" id="destination_limit">
            <input type="hidden" class="form-control" value="0" id="destination_contents">
            <input type="hidden" class="form-control" value="0" id="destination_folder_id">

        </div>
    </div>

</div>
<input type="hidden" class="form-control" value="0" id="selectionLength">

<script>

    function CheckTransfer() {
      /*  if($('.sourceData').filter(':checked').length >= 1){
            $('#btnTransfer').removeAttr('disabled');
        }else{
            $('#btnTransfer').attr('disabled','disabled');
        }*/

    }


    function Transfer(){
        var data = [];
        var selection = [];
        data = $('input[name="sourceData[]"]:checked');
        $.each(data,function(index,obj){
            selection.push(obj.value);
        });

        $.ajax({
            url: "<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/transfer'); ?>",
            type: "POST",
            cache: false,
            data: {
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>',
                transferList: selection,
                source: $("#source").val(),
                destination: $("#destination").val(),

            },
            success: function (data) {
                ResponseGenerator(data,'source');
                ResponseGenerator(data,'destination');
            }
        });
    }


    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
        return val;
    }
    function InitiateTables(target,limit) {
        var segments = 1;
        var segmentLimit = 1;
        var createdSegments= 0;
        if(target!=='destination'){
            var tableHeader =''+
                '        <thead>\n' +
                '            <tr class="bg-blue border-danger double-border">\n' +
                '                <th width="20%">S/N</th>\n' +
                '                <th>FORM #</th>\n' +
                '                <th width="10%"><span class="fa fa-check"></span></th>\n' +
                // '                <th width="20%">ACTION</th>\n' +
                '            </tr>\n' +
                '        </thead>';
        }else {
            var tableHeader =''+
                '        <thead>\n' +
                '            <tr class="bg-blue border-danger double-border">\n' +
                '                <th width="20%">S/N</th>\n' +
                '                <th>FORM #</th>\n' +
                //'                <th width="10%"><span class="fa fa-check"></span></th>\n' +
                // '                <th width="20%">ACTION</th>\n' +
                '            </tr>\n' +
                '        </thead>';
        }


        var segmentData = '';

        var  span =12;
        if (limit>50){
            if (limit % 3 == 0){
                segments = 3;
                segmentLimit = limit/3;
                span=4;
            }else{
                segments = 4;
                segmentLimit = limit/4;
                span=3;
            }
        }else{
            segments=1;
            span=12;
            segmentLimit = limit;
        }

        var counter = 0;



        for (var i=1; i<=segments; i++)
        {
            segmentData+='' +
                '<div class="col-md-'+span+'">' +
                '<table class="table table-bordered table-bordered" id="table_'+i+'">' +
                tableHeader+
                '<tbody id="body_'+i+'">';
            for (var tr = (segmentLimit*(i-1))+1; tr<=(segmentLimit*i); tr++)
            {
                if (target!=='destination'){
                    segmentData+='<tr id="tr_'+target+tr+'">'+
                        //'<th>'+tr+'</th><th id="code_'+tr+'"></th><th><button class="btn btn-danger" id="btn_'+tr+'"><span class="fa fa-trash"></span> Remove</button></th>' +
                        '<th>'+tr+'</th><th id="code_'+target+tr+'"></th><th id="operation_'+target+tr+'"></th>' +
                        '</tr>';
                }else {
                    segmentData+='<tr id="tr_'+target+tr+'">'+
                        //'<th>'+tr+'</th><th id="code_'+tr+'"></th><th><button class="btn btn-danger" id="btn_'+tr+'"><span class="fa fa-trash"></span> Remove</button></th>' +
                        '<th>'+tr+'</th><th id="code_'+target+tr+'"></th>' +
                        '</tr>';
                }

            }



            segmentData+='</tbody>'+
                '</table>' +
                '</div>';
        }

        $("#"+target+"_folder").html(segmentData);
    }
    function CheckLength() {
       var data = [];
       var selection = 0;
       data = $('input[name="sourceData[]"]:checked');
        selection = data.length*1;
       $("#selectionLength").val(selection);
        var destinationContents = $("#destination_contents").val() * 1;

        var destinationLimit = $("#destination_limit").val() * 1;
        var sourceLimit = $("#source_limit").val() * 1;
        $("#sourceSelection").html(commaSeparateNumber(selection));
        $("#sourceLimit").html(commaSeparateNumber(sourceLimit));

        if ((destinationContents+selection)>=destinationLimit){
           //$('input[name="sourceData[]"]:checked').attr("disabled","disabled");
           alert("You can NO longe add more forms to Destination folder");

                $('.sourceData:not(:checked)').attr('disabled', 'disabled');


        }else {
            $('.sourceData').removeAttr("disabled");
        }
    }
    function AppendToTable(count,target,item=null){
        $("#tr_"+target+count).attr("class","bg-green");

        if(item!=null){
            $("#code_"+target+count).html(item);
        }else{
            $("#code_"+target+count).html($("#searchField").val());
        }
        if(target!=='destination'){
            $("#operation_"+target+count).html('<input type="checkbox" onclick="CheckLength()" class="checkbox sourceData" id="sourceData'+target+count+'" name="sourceData[]" value="'+item+'" />');
        }

        $("#countField").val(count);
        //$("#searchField").val("");
        $("#destination").focus();
        $("#logged").html(commaSeparateNumber(count));
        $("#limitField").attr('min',count);
    }
    function SearchFolder(keyWord,target) {

         if ($("#source").val() !== $("#destination").val()) {
            $("#" + target + "_folder").html("<span class='fa fa-spinner fa-spin'></span> Please Wait...");
            $.ajax({
                url: "<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/transfer'); ?>",
                type: "POST",
                cache: false,
                data: {
                    _csrf: '<?=Yii::$app->request->getCsrfToken()?>',
                    keyWord: keyWord,
                    target: target,

                },
                success: function (data) {
                    ResponseGenerator(data,target);

                    CheckTransfer();



                }

            });

        } else {
            alert("Forbidden Operation: Self transfer is no allowed!");
            $("#" + target + "_folder").html("<div class='text-red' style='font-size: xx-large; text-align: center;'><span class='fa fa-ban fa-5x'></span> <p>Source and Destination MUST NOT be equal</p></div>");
        }
        //}




    }

    function ResponseGenerator(data,target) {
        var limit = data[target].folderLimit * 1;
        InitiateTables(target, limit);
        var logged = data[target].folderContent * 1;
        if (data[target].output !== '') {
            //"output":"2018-000002","folderID":1,"folderLimit":"120"
            $("#formNumberField").val(data[target].output);
            $("#" + target + "_folder_id").val(data[target].folderID);
            $("#" + target + "_limit").val(data[target].folderLimit);
            $("#logged").html(commaSeparateNumber(logged));
            $("#limitField").html(commaSeparateNumber(data[target].folderLimit));
            $("#" + target + "_contents").val(logged);

            $("#searchPreview").html('<svg id="barcode"></svg>');
            JsBarcode("#barcode", data.output);
            $("#searchField").focus();


            if (logged != '' && logged > 0) {

                $.each(data[target].formList, function (index, fields) {
                    //console.log(fields);
                    AppendToTable(index + 1, target, fields.application_form_number);
                });
            }
        } else {
            $("#" + target + "_folder").html("<div class='text-danger' style='font-size: large;'><span class='fa fa-ban fa-3x'></span><b>" + keyWord + "</b> Not Found!</div>");
        }




        var destinationContents = $("#destination_contents").val() * 1;
        var destinationLimit = $("#destination_limit").val() * 1;
        if ((destinationContents>=destinationLimit)&&(destinationLimit!==0 && destinationContents!==0)){
            $("#btnTransfer").attr("disabled","disabled");
            //CheckTransfer();
            var message = "Warning!: Destination folder has reached content Limit";
            $("#" + target + "_folder").html("<div class='text-danger' style='font-size: large;'><span class='fa fa-ban fa-3x'></span><b>" + message + "</b></div>");
            alert(message);

        }else{
            $("#btnTransfer").removeAttr("disabled");
            // CheckTransfer();
        }



        CheckLength();


        var sourceLimit =  $("#source_limit").val()*1;
        var destinationLimit =  $("#destination_limit").val()*1;
        var destinationSelection =  $("#destination_contents").val()*1;
        $("#sourceLimit").html(commaSeparateNumber(sourceLimit));
        $("#destinationLimit").html(commaSeparateNumber(destinationLimit));
        $("#destinationSelection").html(commaSeparateNumber(destinationSelection));

    }

    $(document).ready(function () {
        CheckTransfer();
        $("#clearSource").on("click",function () {
            $("#source").val("");
            $("#source_folder").html("");
            $("#source_list").val("");
        });

        $("#clearDestination").on("click",function () {
            $("#destination").val("");
            $("#destination_folder").html("");
            $("#destination_list").val("");
        });

        $("#source").on("change",function () {
            //'19U2018', 'S3571.0008.2011', NULL, 'EMMANUEL PAULO ANDREA', '19U2018', '7', '2018-000001', '120'
            SearchFolder($(this).val(),'source');
        });

        $("#destination").on("change",function () {
            SearchFolder($(this).val(),'destination');


        });

        $("#btnTransfer").on("click",function () {
           var destination = $("#destination").val();
           var source = $("#source").val();

           Transfer();

            SearchFolder(source,'source');
            $("#source").val(source);

            SearchFolder(destination,'destination');
            $("#destination").val(destination);
        });


    });



</script>