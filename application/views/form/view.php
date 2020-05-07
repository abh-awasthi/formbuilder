<div id="page-wrapper">
<div class="main-page">
      
<h2 class="title1">Form Records</h2>
<p class="pull-right hide"><span>Facebook</span></p>
<div class="row" style="margin-right: 0px;" id="">
  <div class="col-md-12">
    <table 
     class="table"
     id="users"
     data-toggle="table"
     data-sortable="true"
     data-search="true"
     data-height="500" 
     data-show-refresh="true"
     data-side-pagination="server"
     data-pagination="true"
     data-show-columns="true"
     data-page-list="[10, 20, 50, 100, 200,500,1000]"
     data-url="<?php echo base_url(); ?>form/get_form_data/<?php echo $slug; ?>"
    >
    <thead>
      
    <tr>

    
    <th data-field="id" >Id</th> 
    <?php foreach ($form_header as $hkey => $hvalue) { ?>
      <th data-field="<?php echo strtolower($hkey); ?>" data-sortable="true" ><?php echo $hvalue; ?>  </th>
    <?php } ?>
    <th data-formatter="actionFormatter" style="padding-right: 30px !important;" data-events="actionEvents" >Action</th> 
   </tr>

    </thead>
  </table>

  </div>
</div>
<!--footer-->
<style>
  tr{
    font-size: 15px;
  }
</style>
<script>
 
  function actionFormatter(value, row, index) {

    return [
      '<a class="delete" style="color:red;padding-left: 8px;" href="javascript:" title="Delete Form"><i class="fa fa-trash"></i></a>'
    ].join('')

  }

 



 // update and delete events
  window.actionEvents = {

'click .delete': function (e, value, row) {
  swal({
  title: "Are you sure want to delete  - "+row['form_id']+" ?",
  type: "warning",
  text: "<img class='hide' id='del"+row['form_id']+"' src='<?php echo base_url(); ?>assets/images/loading.gif' style='width:100px;'>",
  html:true,
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, cancel plx!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm) {
  if (isConfirm) {
    $("#del"+row['form_id']).removeClass("hide");
        $.ajax({
          url: "<?php echo base_url(); ?>form/delete/"+row['form_id'],
          dataType: "json",
           success: function(result){
            $("#del"+row['form_id']).addClass("hide");
            $("#users").bootstrapTable('refresh')
             console.log(JSON.parse(JSON.stringify(result)));
             if (result.status==true) {
              swal("Deleted!",  result.message , "success");
            }else{
              swal("Error", result.message , "error");
            }
            }
     });
    
  } else {
    swal("Cancelled", "Your  delete process was cancelled!", "error");
  }
})
    }
  }


</script>
 