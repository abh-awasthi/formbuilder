<div id="page-wrapper">
  <div class="main-page">
      
<h2 class="title1">All Forms</h2>
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
     data-url="<?php echo base_url(); ?>form/all_forms"
    >
    <thead>
      
    <tr>

    <th data-field="form_id" data-sortable="true" >Id</th>
    <th data-field="title" data-sortable="true" >Title</th>
    <th data-field="slug" data-sortable="true" >Slug</th>
    <th data-field="start_time" data-sortable="true" >Start</th>
    <th data-field="end_time" data-sortable="true" >End</th>
    <th data-field="created_on">Created On</th>
    <th data-formatter="statusFormatter" data-events="actionEvents"  >Status</th>
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
  $("#users").bootstrapTable({
            search: true,
            showColumns: true,
            showRefresh: true,
            pagination: true,
            pageSize: 10, //specify 5 here
            striped: true,
            syncScrollbars: true
  });



  function actionFormatter(value, row, index) {

    return [
      '<a class="edit_user" target="_blank" href="<?php echo base_url(); ?>form/edit/'+row['slug']+'" title="Edit Form"><i class="glyphicon glyphicon-edit"></i></a>',
      '<a class="view_form" target="_blank" href="<?php echo base_url(); ?>form/view/'+row['slug']+'" title="View User"><i class="fa fa-eye"></i></a>',
      '<a class="delete" style="color:red;padding-left: 8px;" href="javascript:" title="Delete Form"><i class="fa fa-trash"></i></a>'
    ].join('')

  }

  function statusFormatter(value, row, index) {
   if (row['active']==1) {
            return [
                   '<span style="background-color:green;color:white;padding: 3px;cursor: pointer;border-radius: 4px;text-align:center;" class="deactivate" href="javascript:" title="Deactivate User">Active</span>'
                    ].join('')

  }else{
            return [
                   '<span style="background-color:red;color:white;padding: 3px;cursor: pointer;border-radius: 4px;"class="activate" href="javascript:" title="Activate User">Deactivated</span>'    ].join('')
      }
  }



 // update and delete events
  window.actionEvents = {
    'click .deactivate': function (e, value, row) {
      

  swal({
  title:  "Are you sure want to deactivate  - "+row['form_id']+" ?",
  type: "warning",
  text: "<img class='hide' id='"+row['form_id']+"' src='<?php echo base_url(); ?>assets/images/loading.gif' style='width:100px;'>",
  html:true,
  showCancelButton: true,
  confirmButtonClass: "btn-danger",
  confirmButtonText: "Yes, deactivate it!",
  cancelButtonText: "No, cancel plx!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm) {
  if (isConfirm) {
    $("#"+row['form_id']).removeClass("hide");
        $.ajax({
          url: "<?php echo base_url(); ?>form/deactivate/"+row['form_id'],
          dataType: "json",
           success: function(result){
            $("#"+row['form_id']).addClass("hide");
            $("#users").bootstrapTable('refresh')
             console.log(JSON.parse(JSON.stringify(result)));
             if (result.status==true) {
              swal("Deactivated!",  result.message , "success");
            }else{
              swal("Error", result.message , "error");
            }
            }
     });
    
  } else {
    swal("Cancelled", "Your  deactivation process was cancelled!", "error");
  }
})



    },
    'click .activate': function (e, value, row) {
       

  swal({
  title: "Are you sure want to activate  - "+row['form_id']+" ?",
  type: "warning",
  text: "<img class='hide' id='act"+row['form_id']+"' src='<?php echo base_url(); ?>assets/images/loading.gif' style='width:100px;'>",
  html:true,
  showCancelButton: true,
  confirmButtonClass: "btn-success",
  confirmButtonText: "Yes, activate it!",
  cancelButtonText: "No, cancel plx!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm) {
  if (isConfirm) {
    $("#act"+row['form_id']).removeClass("hide");
        $.ajax({
          url: "<?php echo base_url(); ?>form/activate/"+row['form_id'],
          dataType: "json",
           success: function(result){
            $("#act"+row['form_id']).addClass("hide");
            $("#users").bootstrapTable('refresh')
             console.log(JSON.parse(JSON.stringify(result)));
             if (result.status==true) {
              swal("Activeted!",  result.message , "success");
            }else{
              swal("Error", result.message , "error");
            }
            }
     });
    
  } else {
    swal("Cancelled", "Your  activation process was cancelled!", "error");
  }
})

    },


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
<style>
  .table-striped{
    width: 100% !important;
  }
</style>