</div>
<footer>
    <div id="lg_footer"><a href="index.php">
    <img src="images/light_1.svg">
      <h4>
          Inspiration
      </h4>
    <div class="clear"></div></a>
    </div>
    <div class="info"> <a href="#">TERMS AND CONDITIONS</a></div>
    <div class="info"> <a href="#">HOW WE USE COOKIES</a></div>
    <div class="info"> <a href="#">INSPIRATION 	&copy; 2018</a></div>   
        <span><a href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i><br>Top</a></span>
    <div class="clear"></div>
   <script src="js/scripts.js"></script>
   <script>
$(document).ready(function(){
 $(document).on('change', '#imageupload', function(){
var form_data = new FormData();
   form_data.append("image_upload", document.getElementById('imageupload').files[0]);
   $.ajax({
    url:"upload.php",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
    },   
    success:function(data)
    {
     $('#uploaded_image').html(data);
    }
   });
 });
});

</script>

</footer>
    </body>
</html>