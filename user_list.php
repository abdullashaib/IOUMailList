<?php

session_start();

ob_start();

 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("includes/include.php");
include("includes/db_connect.php");

page_header();

if(isset($_POST['submit'])) {
  
  $name = $connection->real_escape_string(trim($_POST['name']));
  $email = $connection->real_escape_string(trim($_POST['email']));
  
  $sql = "INSERT INTO mail_list (name, email) VALUES (?,?)";
  $stmt= $connection->prepare($sql);
  $stmt->bind_param("ss", $name, $email);
  //$stmt->execute();
  
  if (!$stmt->execute()) {
    echo "<span id='message' class='error'>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</span>";
  } else {
     // Add user to users table for login
     $connection->query("INSERT INTO users (email, user_password, role) VALUES ('$email','Iou123@$', '2')");
     send_email($email, $url);
     echo "<span id='message' class='success'>Record inserted</span>";
  }


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
      user_password: {
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
<h2>Edit User</h2>  
<form id="mail" action="create_email.php" method="post">
  
  <div class="form-group row">
    <label for="email" class="col-3">Email Address:</label>
    <div class="col-8">
      <input type="email" class="form-control" id="email" name="email" autocomplete="off" />
    </div>
  </div>
  
  <div class="form-group row">
    <label for="user_password" class="col-3">Password:</label>
    <div class="col-8">
      <input type="password" class="form-control" id="user_password" name="user_password" autocomplete="off" />
    </div>
  </div>
  
  <div class="form-group row">
    <label for="role" class="col-3">User Role:</label>
    <div class="col-8">
      <select class="form-control" id="role	=" name="role">
          <option value="1">Admin User</option>
          <option value="2">Subscriber</option>
      </select>
    </div>
  </div>
 
  <div class="form-group row">
    <div class="offset-3 col-8">
      <button type="submit" name="submit" class="btn btn-success"><i class="far fa-save"></i> Add to List</button>
      <a href="email_list.php" class="btn btn-info"><i class="far fa-list-alt"></i> Back to List</a>
    </div>                                             
  </div>
  
</form> 


<?php  
} else {

  $sql = "SELECT id, email, role FROM users ORDER BY email";
  $results = $connection->query($sql);
  
?>
<h2>User List</h2>
<table class="table table-bordered" style="font-size: 12px;">
  <tr>
    <th></th>
    <th>Email</th>
    <th>Role</th>
    <th></th>
  </tr>

<?php 
$i = 1;

foreach ( $results as $result ) {
?>
  <tr>
    <td><?=$i;?></td>
    <td><?=$result['email'];?></td>
    <td><?=$result['role'];?></td>
    <td>
      <a href="edit_email.php?id=<?=$result['id'];?>" class="btn btn-primary"><i class="far fa-edit"></i> Edit</a>
      <a href="delete_email.php?id=<?=$result['id'];?>" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</a>
    </td>
  </tr>
<?php
  $i++;
}
?>
</table>  
<?php 

}
$connection->close();

page_footer();