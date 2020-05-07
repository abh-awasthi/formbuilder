  <div class="footer">
     <p>&copy; 2019 AA Software Pvt Ltd. All Rights Reserved | Design by <a href="#" target="_blank">AA Softwares</a></p>   
  </div>
    </div>
</div>
    <!--//footer-->
				<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>

			<!--scrolling js-->
	 <script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js" ></script>
	<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='<?php echo base_url(); ?>assets/js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	

<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>

<link href="<?php echo base_url(); ?>assets/css/bootstraptable.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
<link href="<?php echo base_url(); ?>assets/css/sweetalert.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/datetimepicker.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/js/sweetalert.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetimepicker.js"></script>

<style type="text/css">
 
 </style>