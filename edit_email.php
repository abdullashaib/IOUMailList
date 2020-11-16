<?php


include("includes/include.php");
include("includes/db_connect.php");

page_header();

$id = $connection->real_escape_string(trim($_GET['id']));

$URL = "http://ioc.actwazalendo.org/email_list.php";

if(isset($_POST['update'])) {

  $email_id = $connection->real_escape_string(trim($_POST['email_id']));
  $name = $connection->real_escape_string(trim($_POST['name']));
  $email_address = $connection->real_escape_string(trim($_POST['email']));
  $validated = $connection->real_escape_string(trim($_POST['is_validated']));
  
  $connection->query("UPDATE mail_list SET name = '$name', email = '$email_address', is_validated = '$validated' WHERE id = '$email_id'");

  echo "<span id='message' class='success'>Record updated </span>";
  
  echo "<br /><a href='email_list.php'>Back to List</a>";
  
  header('Location: '.$URL);
  exit();
?>

<?php  
} else {

  $sql = "SELECT id, name, email, is_validated FROM mail_list WHERE id=?";
  $stmt = $connection->prepare($sql); 
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result(); 
  $output = $result->fetch_assoc();   

?>

<script>
$(document).ready(function() {
  
  $("#mail").validate({
    
    rules: {
      email: {  
        required: true,
        email: true
      },
      name: {
        required: true
      }
    },
    // Specify validation error messages
    messages: {
      email: {
        required: "Email name is required",
        email: "Please enter valid email"
      },
      name: {
        required: "Full name is required"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
  });   

});

$('#message').fadeIn().delay(10000).fadeOut();

</script>

<h2>Add User to Newsletter List</h2>  
<form id="mail" action="edit_email.php" method="post">

  <input type="hidden" name="email_id" value="<?=$output['id'];?>" />
  <div class="form-group row">
    <label for="name" class="col-3">Full Name:</label>
    <div class="col-8">
      <input type="text" class="form-control" id="name" name="name" value="<?=$output['name'];?>" />
    </div>
  </div>
  
  <div class="form-group row">
    <label for="email" class="col-3">Email Address:</label>
    <div class="col-8">
      <input type="email" class="form-control" id="email" name="email" value="<?=$output['email'];?>" />
    </div>
  </div>
  
  <div class="form-group row">
    <label for="email" class="col-3">Is Validated:</label>
    <div class="col-8">
      <select class="form-control" id="is_validated" name="is_validated">
         <option value="Yes" <?php if($output['is_validated']=="Yes") echo 'selected="selected"'; ?>>Yes</option>
         <option value="No" <?php if($output['is_validated']=="No") echo 'selected="selected"'; ?>>No</option>
      </select>
    </div>
  </div>
  
  <div class="form-group row">
    <div class="offset-3 col-8">
      <button type="submit" name="update" class="btn btn-success"><i class="far fa-save"></i> Update Email</button>
      <a href="email_list.php" class="btn btn-info"><i class="far fa-list-alt"></i> Back to List</a>
    </div>                                             
  </div>
  
</form> 
 
<?php
} 

$connection->close();

page_footer();
