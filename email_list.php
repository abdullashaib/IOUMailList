<?php

session_start();

ob_start();

include("includes/include.php");
include("includes/db_connect.php");

page_header();

  $sql = "SELECT id, name, email, is_validated FROM mail_list ORDER BY name";
  $emails = $connection->query($sql);
  
?>
<div class="row">
  <div class="col-6">
    <h2> Email List</h2>
  </div>
  <div class="col-6">
    <a href="create_email.php" class="btn btn-success"><i class="fas fa-plus"></i> Create</a>
  </div>
</div>
<table class="table table-bordered" style="font-size: 12px;">
  <tr>
    <th></th>
    <th>Name</th>
    <th>Email</th>
    <th>Validated</th>
    <th></th>
  </tr>

<?php 
$i = 1;

foreach ( $emails as $email ) {
?>
  <tr>
    <td><?=$i;?></td>
    <td><?=$email['name'];?></td>
    <td><?=$email['email'];?></td>
    <td><?=$email['is_validated'];?></td>
    <td>
      <a href="edit_email.php?id=<?=$email['id'];?>" class="btn btn-primary"><i class="far fa-edit"></i> Edit</a>
      <a href="delete_email.php?id=<?=$email['id'];?>" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</a>
    </td>
  </tr>
<?php
  $i++;
}
?>
</table>  
<?php 
  
$connection->close();

page_footer();
