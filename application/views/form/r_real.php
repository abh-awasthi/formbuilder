<div id="formBuilder">
     
     

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
 

 


     var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("formBuilder").innerHTML = this.responseText;
                console.log(this.responseText);
            }
        };
        xmlhttp.open("GET", "http://localhost/formbuilder/form/render_real/my-form", true);
        xmlhttp.send();




</script> 
 