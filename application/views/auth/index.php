<?php include('header.php'); ?>
<div class="continer">
<h1><?php echo lang('index_heading');?></h1><p><?php //echo anchor('auth/create_user', lang('index_create_user_link'))?>   <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p>
<p><?php echo lang('index_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>
<div class="row" style="margin-right: 0px;">
	<div class="col-md-12">
		<table 
	  	class="table"
		 id="users"
		 data-toggle="table"
		 data-sortable="true"
		 data-search="true"
     data-height="400" 
		 data-show-refresh="true"
		 data-side-pagination="server"
		 data-pagination="true"
		 data-show-columns="true"
		 data-page-list="[5,10, 20, 50, 100, 200,500,1000]"
		 data-url="<?php echo base_url(); ?>auth/users"

		>
    <thead>
      
    <tr>
    <th data-field="id" data-sortable="true" >Id</th>
    <th data-field="first_name" data-sortable="true" >Fisrt Name</th>
    <th data-field="last_name" data-sortable="true" >Last Name</th>
    <th data-field="email" data-sortable="true" >Email</th>
    <th data-field="phone" data-sortable="true" >Phone</th>
    <th data-field="last_login"   >Last Login</th>
    <th data-field="ip_address"   >Ip Address</th>
    <th data-field="signup_on"   >Created On</th>
    <th data-formatter="statusFormatter" data-events="actionEvents"  >Status</th>
    <th data-formatter="actionFormatter" data-events="actionEvents" >Action</th> 
  </tr>

    </thead>


</table>

	</div>
</div>
<div>
<style>
  tr{
        font-size: 15px;
  }
  .bootstrap-table{
 
  }
</style>
<script>
	$("#users").bootstrapTable({


		        search: true,
            showColumns: true,
            showRefresh: true,
            pagination: true,
            syncScrollbars: true
	});



	function actionFormatter(value, row, index) {

    return [
      '<a class="edit_user" target="_blank" href="<?php echo base_url(); ?>auth/edit_user/'+row['id']+'" title="Edit User"><i class="glyphicon glyphicon-edit"></i></a>',
      '<a class="delete" style="color:red;padding: 10px;" href="javascript:" title="Delete User"><i class="fa fa-trash"></i></a>'
    ].join('')

  }

  function statusFormatter(value, row, index) {
         if (row['active']==1) {
            return [
      '<span style="background-color:green;color:white;padding: 3px;cursor: pointer;border-radius: 4px;text-align:center;" class="deactivate" href="javascript:" title="Deactivate User">Active</span>'
    ].join('')

      }else{

            return [
      '<span style="background-color:red;color:white;padding: 3px;cursor: pointer;border-radius: 4px;" class="activate" href="javascript:" title="Activate User">Deactivated</span>'    ].join('')

      }
  }



 // update and delete events
  window.actionEvents = {
    'click .deactivate': function (e, value, row) {
      

  swal({
  title:  "Are you sure want to deactivate user id - "+row['id']+" ?",
  type: "warning",
  text: "<img class='hide' id='"+row['id']+"' src='<?php echo base_url(); ?>assets/images/loading.gif' style='width:100px;'>",
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
    $("#"+row['id']).removeClass("hide");
        $.ajax({
          url: "<?php echo base_url(); ?>auth/deactivate/"+row['id'],
          dataType: "json",
           success: function(result){
            $("#"+row['id']).addClass("hide");
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
    swal("Cancelled", "Your user deactivation process was cancelled!", "error");
  }
})



    },
    'click .activate': function (e, value, row) {
       

  swal({
  title: "Are you sure want to activate user id - "+row['id']+" ?",
  type: "warning",
  text: "<img class='hide' id='act"+row['id']+"' src='<?php echo base_url(); ?>assets/images/loading.gif' style='width:100px;'>",
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
    $("#act"+row['id']).removeClass("hide");
        $.ajax({
          url: "<?php echo base_url(); ?>auth/activate_by_admin/"+row['id'],
          dataType: "json",
           success: function(result){
            $("#act"+row['id']).addClass("hide");
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
    swal("Cancelled", "Your user activation process was cancelled!", "error");
  }
})

    },


  'click .delete': function (e, value, row) {
       

  swal({
  title: "Are you sure want to delete user id - "+row['id']+" ?",
  type: "warning",
  text: "<img class='hide' id='del"+row['id']+"' src='<?php echo base_url(); ?>assets/images/loading.gif' style='width:100px;'>",
  html:true,
  showCancelButton: true,
  confirmButtonClass: "btn-success",
  confirmButtonText: "Yes, delete it!",
  cancelButtonText: "No, cancel plx!",
  closeOnConfirm: false,
  closeOnCancel: false
},
function(isConfirm) {
  if (isConfirm) {
    $("#del"+row['id']).removeClass("hide");
        $.ajax({
          url: "<?php echo base_url(); ?>auth/delete_by_admin/"+row['id'],
          dataType: "json",
           success: function(result){
            $("#del"+row['id']).addClass("hide");
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
    swal("Cancelled", "Your user delete process was cancelled!", "error");
  }
})

    }


  }


</script>
