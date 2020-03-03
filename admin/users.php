<?php
  ob_start();
  session_start();
  if(isset($_SESSION['email'])) {
        $pageTitle = 'Users';
    include 'init.php';
    $fdo = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    $do =  filter_var(strip_tags($fdo), FILTER_SANITIZE_STRING);
    if($do == 'Manage'){
      $stmt = $con->prepare("SELECT * FROM users");
      $stmt->execute();
      $rows = $stmt->fetchAll();
   ?>
  <div class="all-c users">
    <div class="container">
      <h2 class="text-center users-header">Users page</h2>
      <div class="users-table">
        <table>
          <thead>
            <tr>
              <td>control</td>
              <td>comments</td>
              <td>likes</td>
              <td>Email</td>
              <td>country</td>
              <td>Age</td>
              <td>name</td>
            </tr>
          </thead>
          <?php
            foreach($rows as $mrow){
          ?>
          <tbody>
            <td>
            <?php echo   "<a href='?do=Delete&id=" .$mrow['id']. "'><button class='btn btn-danger confirm'>Delete</button></a>"; ?>
            </td>
            <td><?php echo countColumn('comment', 'comments', 'user_id', $mrow['id']); ?></td>
            <td><?php echo countColumn('likeit', 'likes', 'user_id', $mrow['id']); ?></td>
            <td><?php echo strip_tags($mrow['email'])?></td>
            <td><?php echo htmlspecialchars($mrow['country'])?></td>
            <td><?php echo htmlspecialchars($mrow['age'])?></td>
            <td class="sname"><?php echo htmlspecialchars($mrow['username'])?></td>
          </tbody>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
  <?php
}elseif($do == 'Delete'){
    $id  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $userid =filter_var(strip_tags($id), FILTER_SANITIZE_NUMBER_INT	);
?>
<div class="all-c users">
  <div class="container">
    <?php
      $udstmt = $con->prepare("SELECT * FROM users WHERE id = ?");
      $udstmt->execute(array($userid));
      $count = $udstmt->rowCount();
      if($count > 0){
        $udastmt = $con->prepare("DELETE FROM users WHERE id = ? LIMIT 1");
        $udastmt->execute(array($userid));
        $theMsg = '<div class="alert alert-success">the users is deleted. </div>';
        redirectTo($theMsg, 'users.php');
      }else{
        $theMsg = '';
        redirectTo($theMsg, 'users.php', 1);
      }
?>
</div>
</div>
<?php
}else{
  $theMsg =  '';
  redirectTo($theMsg, 'dashboard.php');
}


 include $temps . 'footer.php';
  }else{
    header('Location:index.php');
    exit();
  }
  ob_end_flush();
?>
