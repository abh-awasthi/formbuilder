<h1><?php echo lang('create_group_heading');?></h1>
<p><?php echo lang('create_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>



        <form class="form-signin" method="POST" action="<?php echo  base_url(); ?>auth/login">
     
            <input type="text" name="group_name" id="inputEmail" class="form-control" placeholder="Group name" required="" autofocus="">
            <input type="text" name="description" id="inputPassword" class="form-control" placeholder="Group description" required="">
            
            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Create Group</button>
            </form>



<?php echo form_open("auth/create_group");?>

      <p>
            <?php echo lang('create_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo lang('create_group_desc_label', 'description');?> <br />
            <?php echo form_input($description);?>
      </p>

      <p><?php echo form_submit('submit', lang('create_group_submit_btn'));?></p>

<?php echo form_close();?>