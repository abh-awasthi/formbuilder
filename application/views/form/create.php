<div id="page-wrapper">
<div class="main-page">
<h2 class="title1">Create Form</h2>
<div class="row" style="margin-right: 0px;" id="">
    <div class="col-md-12">
         
    <div id="master-container" style="margin-top: 20px">

      <div id="formBuilder">
          

      </div>



    </div>  

    </div>
</div>


  <link rel="stylesheet" href="<?php echo  base_url(); ?>assets/src/css/style.css">
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>assets/js/jquery2.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/libraries/dust-js/dust-core-0.3.0.min.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/libraries/dust-js/dust-full-0.3.0.min.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/libraries/dust-js/dust-helpers.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/libraries/tabs.jquery.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/formBuilder.jquery.js"></script>
    <link rel="stylesheet" href="<?php echo  base_url(); ?>assets/css/bootstrap.css" />

    <script>

      $('#formBuilder').formBuilder({
        
        load_url: 'http://localhost/formbuilder/assets/src/json/example.json',
        save_url: '<?php echo base_url() ?>form/saveForm',
        
        onSaveForm: function() {
          // redirect to demo page
          window.location.href = '<?php echo base_url() ?>form/saveForm';
        }

      });

    </script>
    <script>
      
    
            /*jslint browser:true*/
            /*global jQuery, document*/

            jQuery(document).ready(function () {
                'use strict';

               jQuery('#form-validfrom').datetimepicker({
  format:'Y-m-d H:i',
  onShow:function( ct ){
   this.setOptions({
    maxDate:jQuery('#form-validtill').val()?jQuery('#form-validtill').val():false
   })
  },
  timepicker:true,
  minDate:0
 });
 jQuery('#form-validtill').datetimepicker({
  format:'Y-m-d H:i',
  onShow:function( ct ){
   this.setOptions({
    minDate:jQuery('#form-validfrom').val()?jQuery('#form-validfrom').val():false
   })
  },
  timepicker:true,
  minDate:0
 });
            });

  

    </script>
 
