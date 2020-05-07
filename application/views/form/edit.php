<div id="page-wrapper">
<div class="main-page">
<h2 class="title1">Edit Form</h2>
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

    <script src="<?php echo  base_url(); ?>assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/libraries/dust-js/dust-core-0.3.0.min.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/libraries/dust-js/dust-full-0.3.0.min.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/libraries/dust-js/dust-helpers.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/libraries/tabs.jquery.js"></script>
    <script src="<?php echo  base_url(); ?>assets/src/formBuilder.jquery.js"></script>
    <link rel="stylesheet" href="<?php echo  base_url(); ?>assets/css/bootstrap.css" />



    <script>

      $('#formBuilder').formBuilder({
        load_url: '<?php echo base_url() ?>form/getFormJSON/<?php echo $slug; ?>',
        save_url: '<?php echo base_url() ?>form/editForm/<?php echo $slug; ?>',
        onSaveForm: function() {
          // redirect to demo page
          window.location.href = '<?php echo base_url() ?>form/editForm/<?php echo $slug; ?>';
        }
      });

    </script>
    <script>
    $(document).on('click', '#embed_generate' , function() {
     //code here ....

          $.ajax({
           url: "<?php echo base_url(); ?>form/generate_embed_code/<?php echo $slug; ?>",
           success: function(data) {
             
             var result =  JSON.parse($.trim(data));
             console.log(result);
             $("#code").fadeOut(function() {
             $(this).text(result.embed).slideDown();

            });
           }
           }) 
          
      });






    $(document).on('click', '#form-settings' , function() {
     //code here ....
 
  $('#form-validfrom').datetimepicker({
  format:'d-m-Y H:i',
  onShow:function( ct ){
   this.setOptions({
    maxDate:$('#form-validtill').val()?$('#form-validtill').val():false
   })
  },
  timepicker:true
 });
 $('#form-validtill').datetimepicker({
  format:'d-m-Y H:i',
  onShow:function( ct ){
   this.setOptions({
    minDate:$('#form-validfrom').val()?$('#form-validfrom').val():false
   })
  },
  timepicker:true
 });

      });


    </script>
 

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Embed Code</h4>
        </div>
        <div class="modal-body">
          <textarea class="form-control" rows="10" id="code"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="myFunction();" >Copy</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<script>
   function myFunction() {
  /* Get the text field */
  var copyText = document.getElementById("code");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}
</script>
<script>
  

 


</script>