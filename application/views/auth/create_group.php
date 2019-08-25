<?php include('header.php'); ?>

<div style="width: 30% ; margin: 0 auto;" class="row">
	

<div  class="col-md-12">
<h1><?php echo lang('create_group_heading');?></h1>
<p><?php echo lang('create_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

	           <form class="form-signin" method="POST" action="<?php echo  base_url(); ?>auth/create_group">
     
            <input type="text" name="group_name" id="inputEmail" class="form-control" placeholder="Group name" required="" autofocus="">
            <input type="text" name="description" id="inputPassword" class="form-control" placeholder="Group description" required="">
            
            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Create Group</button>
            </form>

</div>

</div>


