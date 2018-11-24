<?php
/**
 * Created by PhpStorm.
 * User: obedy
 * Date: 8/13/18
 * Time: 3:41 PM
 */
?>
<table class="table table-bordered table-striped table-condensed">
    <thead>
    <tr>
        <th width="20px">S/N</th>
        <th>Folder Number</th>
        <th class="text-center">Folder Capacity</th>
        <th class="text-center">Folder Contents</th>
        <th width="20px">Actions</th>
    </tr>
    </thead>
   <tbody id="folder_list">
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
   </tbody>
</table>

<script>
    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        }
        return val;
    }
   // $(function () {
   function SearchFolder(){
       $("#folder_list").html("<tr><td colspan='5' style='font-size: large;'><span class='fa fa-spinner fa-spin fa-3x'></span> Please Wait...</td></tr>");
       var keyWord =$("#searchFolder").val();
       var year =$("#searchYear").val();
       $.ajax({
           url:"<?php echo Yii::$app->urlManager->createUrl('/application/form-storage/searcher2'); ?>",
           type:"POST",
           cache:false,
           data:{
               _csrf : '<?=Yii::$app->request->getCsrfToken()?>',
               keyWord:keyWord,
               year:year,

           },
           success:function (data) {
                console.log(data);
               $("#folder_list").html("");
               var limit = data.folderLimit*1;
               var logged =  data.folderContent*1;
               if (data.output!==''){
                   var counter = 0;
                   $.each(data,function (index,object) {
                       counter++;
                       $("#folder_list").append('' +
                           '<tr style="font-size: large;">' +
                                '<td>'+counter+'</td>' +
                                '<td class="text-blue" style="font-size: large;"><span class="fa fa-archive fa-3x text-blue"></span><svg id="code'+object.folderID+'"></svg></td>' +
                                '<td class="text-right">'+commaSeparateNumber(object.folderLimit)+'</td>' +
                                '<td class="text-right">'+commaSeparateNumber(object.folderContent)+'</td>' +
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
                       JsBarcode("#code"+object.folderID,object.output, {
                           //format: "pharmacode",
                           lineColor: "#000",
                           width: 4,
                           height: 18,
                           displayValue: true
                       });

                   });






               }else{
                   $("#folder_list").html("<tr class='text-danger'><td colspan='5' style='font-size: large;'><span class='fa fa-ban fa-3x'></span> Records Not Found!</td></tr>");
               }
           }


       });

   }
   $(document).ready(function () {
        $("#btnSearch").on("click",function () {
            SearchFolder();
        });

        $("#clearSearchFolder").on("click",function () {
            $("#searchFolder").val("");
        });

       $("#clearSearchYear").on("click",function () {
           $("#searchYear").val("");
       });

       $("#searchYear").on("change",function () {
           SearchFolder();

       });

       $("#searchFolder").on("change",function () {
           SearchFolder();

       });
   });


   /*$("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });*/
   // });
</script>