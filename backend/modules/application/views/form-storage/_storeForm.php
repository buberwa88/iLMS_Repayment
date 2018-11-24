<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/11/18
 * Time: 8:14 AM
 */

?>
<div class="row">

    <div class="col-md-9">
        <?php //echo QRcode::data('meeeh'); ?>

        <form class="form-horizontal" action="#" method="POST">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5" style="font-size: x-large; font-weight: bolder;">

                            <div class="input-group">
                                <input id="searchField" placeholder="Form Searching" type="text" class="form-control" style="font-size: x-large; font-weight: bolder; height: auto;" tabindex="1">
                                <span class="input-group-addon bg-blue"><button type="button" id="clearSearchField" class="btn btn-primary"><span class="fa fa-magic"></span>Clear</button></span>
                            </div>

                         <input id="folderID" type="hidden" class="form-control" style="font-size: x-large; font-weight: bolder; height: auto;" tabindex="2">
                         <input id="formNumberField" value="" type="hidden" class="form-control" style="font-size: x-large; font-weight: bolder; height: auto;" tabindex="-1">
                         <input id="queueField" type="hidden" class="form-control"  tabindex="-1">
                        <input id="countField" type="hidden" value="0" class="form-control" style="font-size: x-large; font-weight: bolder; height: auto;" tabindex="-1">
                       </div>
                    <div class="col-md-4">
                        <!--<img  height="100px" src="image/loader/loader.gif"  />-->
                        <div class="input-group">
                            <input id="searchFolder" placeholder="Folder Searching" type="text" class="form-control" style="font-size: x-large; font-weight: bolder; height: auto;" tabindex="-1">
                            <span class="input-group-addon bg-blue"><button type="button" class="btn btn-primary" id="btnSearchFolder"><span class="fa fa-search"></span>Search</button></span>
                        </div>
                        <!--<svg id="barcode"></svg>-->

                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon bg-blue">Folder Limit</span>
                            <input id="limitField" type="number" min="0" value="" class="form-control col-lg-3 border-danger" style="font-size: x-large; font-weight: bolder; height: auto;" tabindex="-1">
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-5" id="search_feedback">

                </div>
                <div class="col-md-5">
                    <div id="searchPreview">

                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-xl btn-primary" id="btnNewFolder" data-toggle="modal" data-target="#newFolderModal"><b><span class="fa fa-folder-open"></span></b>Open a New Folder</button>
                   <!-- <button type="button" class="btn btn-xl btn-primary"  data-toggle="modal" data-target="#DemoModal"><b><span class="fa fa-folder-open"></span></b>Demo Codes</button>
                --></div>
            </div>

        </form>

    </div>

    <div class="col-md-3">
        <div class="panel bg-blue">
            <div class="panel-body bg-blue-gradient">
                <div class="row">
                    <div class="col-md-5" style="font-size: 40px; font-weight: bolder;" id="logged"></div>
                    <div class="col-md-2" style="font-size: 40px; font-weight: bolder; text-align: center">/</div>
                    <div class="col-md-5" style="font-size: 40px; font-weight: bolder;" id="folder_limit"></div>
                </div>
            </div>

        </div>

       <!-- <table class="table table-bordered">
            <tbody id="demo_body"></tbody>
        </table>-->

    </div>


</div>

<div class="row" id="tabular_preview">
    <table class="table table-bordered table-bordered">
        <thead>
            <tr class="bg-blue border-danger double-border">
                <th>S/N</th>
                <th>FORM #</th>
                <th>ACTION</th>
            </tr>
        </thead>
    </table>
</div>



<div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title text-uppercase text-bold"><span class="fa fa-folder-open fa-3x"></span> Open New Folder</h4>
           </div>
           <div class="modal-body">


                <form>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon bg-blue">Folder Limit</span>
                            <input id="limit" name="limit" type="number" min="0" value="0" class="form-control col-lg-3 border-danger" style="font-size: x-large; font-weight: bolder; height: auto;" tabindex="-1">
                        </div>
                    </div>



                </form>
           </div>
           <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btnCreate" id="btnCreate" data-dismiss="modal">Create</button>
           </div>
       </div>
    </div>
</div>














<script>


    $("#searchField").focus();
    $("#limitField").attr('min',($("#countField").val()*1));

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
        return val;
    }
    function AppendToTable(count,item=null){
        $("#tr_"+count).attr("class","bg-green");

        if(item!=null){
            $("#code_"+count).html(item);
        }else{
            $("#code_"+count).html($("#searchField").val());
        }


        $("#countField").val(count);
        $("#searchField").val("");
        $("#searchField").focus();
        $("#logged").html(commaSeparateNumber(count));
        $("#limitField").attr('min',count);
    }
    function CreateFolder() {
        $("#searchPreview").html("<span class='fa fa-spinner fa-spin'></span> Please Wait...");
        $.ajax({
            url: "<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/folder'); ?>",
            type: "POST",
            cache: false,
            data: {
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>',
                limit: $("#limit").val(),

            },
            success: function (data) {
               // console.log(data);
                //JsBarcode("#barcode", $("#formNumberField").val());
                if (data.output !== '') {
                    //"output":"2018-000002","folderID":1,"folderLimit":"120"
                    $("#formNumberField").val(data.output);
                    $("#searchFolder").val(data.output);
                    $("#folderID").val(data.folderID);
                    $("#folder_limit").html(commaSeparateNumber(data.folderLimit));
                    $("#limitField").val(data.folderLimit);
                    $("#countField").val(0);
                    //JsBarcode("#barcode", data.output);
                    $("#searchPreview").html('<svg id="barcode"></svg>');
                    JsBarcode("#barcode",data.output);
                    $("#searchField").focus();

                    InitiateTables(data.folderLimit);
                }
            }


        });

    }
    function SearchFolder(){
            $("#searchPreview").html("<span class='fa fa-spinner fa-spin'></span> Please Wait...");
            var keyWord =$("#searchFolder").val();
            $.ajax({
                url:"<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/searcher'); ?>",
                type:"POST",
                cache:false,
                data:{
                    _csrf : '<?=Yii::$app->request->getCsrfToken()?>',
                    keyWord:keyWord,

                },
                success:function (data) {

                    var limit = data.folderLimit*1;
                    InitiateTables(limit);
                    var logged =  data.folderContent*1;
                    if (data.output!==''){
                        //"output":"2018-000002","folderID":1,"folderLimit":"120"
                        $("#formNumberField").val(data.output);
                        $("#folderID").val(data.folderID);
                        $("#folder_limit").html(commaSeparateNumber(data.folderLimit));
                        $("#logged").html(commaSeparateNumber(logged));
                        $("#limitField").val(data.folderLimit);
                        $("#countField").val(logged);

                        $("#searchPreview").html('<svg id="barcode"></svg>');
                        JsBarcode("#barcode",data.output);
                        $("#searchField").focus();


                        if(logged!=''&&logged>0){

                            $.each(data.formList,function (index,fields) {
                                //console.log(fields);
                                AppendToTable(index+1,fields.application_form_number);
                            });
                        }
                    }else{
                        $("#searchPreview").html("<div class='text-danger' style='font-size: large;'><span class='fa fa-ban fa-3x'></span><b>"+keyWord+"</b> Not Found!</div>");
                    }
                }


            });

    }
    function InitiateTables(limit) {
        var segments = 1;
        var segmentLimit = 1;
        var createdSegments= 0;
        var tableHeader =''+
            '        <thead>\n' +
            '            <tr class="bg-blue border-danger double-border">\n' +
            '                <th width="20%">S/N</th>\n' +
            '                <th>FORM #</th>\n' +
           // '                <th width="20%">ACTION</th>\n' +
            '            </tr>\n' +
            '        </thead>';

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
            span=3;
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
                segmentData+='<tr id="tr_'+tr+'">'+
                                //'<th>'+tr+'</th><th id="code_'+tr+'"></th><th><button class="btn btn-danger" id="btn_'+tr+'"><span class="fa fa-trash"></span> Remove</button></th>' +
                                '<th>'+tr+'</th><th id="code_'+tr+'"></th>' +
                                '</tr>';
            }



            segmentData+='</tbody>'+
                '</table>' +
                '</div>';
        }

        $("#tabular_preview").html(segmentData);
    }
    function LogFile(){
        $("#search_feedback").html("<span class='fa fa-spinner fa-spin'></span> Please Wait...");
        var keyWord = $("#searchField").val();
        var folderID = $("#folderID").val();
        var sequence = ($("#countField").val()*1)+1;
        $.ajax({
            url:"<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/store'); ?>",
            type:"POST",
            cache:false,
            data:{
                _csrf : '<?=Yii::$app->request->getCsrfToken()?>',
                keyWord:keyWord,
                folderID:folderID,
                sequence:sequence,

            },
            success:function (data) {
                //console.log(data);
                $("#searchField").focus();
                if (data.output!=''){
                    var folderLimit = ($("#limitField").val()*1);
                    var logged = ($("#countField").val()*1);
                    if(logged<folderLimit){
                        var count = logged+1;
                        AppendToTable(count);
                        $("#search_feedback").html("<div class='text-success' style='font-size: x-large;'><span class='fa fa-check fa-5x'></span><b>"+keyWord+"</b> Success!</div>");
                    }else {
                        $(this).val("");
                        $(this).attr("readonly","readonly");
                        $(this).attr("disabled","disabled");
                        alert("You've reached a folder limit of "+commaSeparateNumber(folderLimit)+". Please Open a new folder or adjust the limit to proceed ");

                    }

                }else{
                    $("#search_feedback").html("<div class='text-danger' style='font-size: x-large;'><span class='fa fa-ban fa-5x'></span><b>"+keyWord+"</b> Failed!</div>");

                }
            }


        });

    }


    function DemoDarcodes(){
        for (var i=1; i<=20; i++){
            var code = i+'U2018';


            $("#demo_body").append(
                '<tr>' +
                    '<td><svg id="code'+code+'"></svg></td>' +
                    '<td>' +code+'</td>' +
                '</tr>'
            );

            JsBarcode("#code"+code, code, {
                //format: "pharmacode",
                lineColor: "#0aa",
                width: 4,
                height: 40,
                displayValue: true
            });



        }
    }

    $(document).ready(function () {
           // DemoDarcodes();
        $("#btnSearchFolder").on("click",function () {
            SearchFolder()
        });

        $("#btnCreate").on("click",function () {
            CreateFolder();
        });


        $("#btnFocus").on("click",function () {
            $("#searchField").focus();
        });


        $("#clearSearchField").on("click",function () {
            $("#searchField").val("");
            $("#searchField").focus();
        });
        //JsBarcode("#barcode", $("#formNumberField").val());

      /*  JsBarcode("#barcode", "2018-000001", {
            format: "pharmacode",
            lineColor: "#0aa",
            width: 4,
            height: 40,
            displayValue: true
        });*/





        $("#searchField").focus();
        var folderLimit = $("#limitField").val()*1;
        var logged = $("#countField").val()*1;
        $("#folder_limit").html(commaSeparateNumber(folderLimit));
        $("#logged").html(commaSeparateNumber(logged));
        $("#limitField").attr('min',($("#countField").val()*1));


        if(logged==0){
            InitiateTables(folderLimit);
        }else{

        }

        $("#limitField").attr('min',($("#countField").val()*1));

        $("#limitField").on('change keyup',function () {
            folderLimit = ($(this).val()*1);

            $("#folder_limit").html(commaSeparateNumber($(this).val()*1));
            if(($("#countField").val()*1)<folderLimit){
                $("#folder_limit").html(commaSeparateNumber($(this).val()*1));

                 //console.log(folderLimit);

                $("#searchField").removeAttr("readonly");
                $("#searchField").removeAttr("disabled");
                $("#searchField").focus();
            }else {
                $("#searchField").val("");
                $("#searchField").attr("readonly","readonly");
                $("#searchField").attr("disabled","disabled");
                alert("You've reached a folder limit of "+commaSeparateNumber(folderLimit)+". Please Open a new folder or adjust the limit to proceed ");
            }
        });


       $("#searchField").on('change',function () {
          LogFile();

       });
    });
</script>