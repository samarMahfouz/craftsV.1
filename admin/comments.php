<?php
    ob_start();
    session_start();
    $pageTitle = 'comments';
    if(isset($_SESSION['email'])) {
    include 'init.php';

    $fdo = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    $do =filter_var(strip_tags($fdo), FILTER_SANITIZE_STRING	);
    if($do == 'Manage'){
      $stmt = $con->prepare("SELECT
                                comments.*, users.username AS user_name, items.name AS item_name
                               FROM
                                  comments
                              INNER JOIN
                                items
                              ON
                                items.id  = comments.post_id
                              INNER JOIN
                                users
                              ON
                                users.id = comments.user_id
                              ");
      $stmt->execute();
      $rows = $stmt->fetchAll();

 ?>
    <div class="all-c users ">
      <div class="container">
        <h2 class="text-center comments-header">comments</h2>
        <div class="users-table comments-table">
          <table>
            <thead>
              <tr>
                <td> delete</td>
                <td>article </td>
                <td>like</td>
                <td>reply</td>
                <td>comment</td>
                <td> name</td>
              </tr>
            </thead>
            <?php
              foreach($rows as $mrow){
                $comment_reply = filter_var(strip_tags($mrow['comment_reply']), FILTER_SANITIZE_STRING	);
            ?>
            <tbody>

              <td>
              <?php echo   "<a href='?do=Delete&id=" .$mrow['id']. "'><button class='btn btn-danger confirm'>Delete</button></a>"; ?>
              </td>
              <td><?php echo strip_tags($mrow['item_name'])?></td>
              <td>
                <?php echo   "<a href=''><button class='btn btn-info confirm'>like</button></a>"; ?>
              </td>
              <td>
                <?php echo $comment_reply; ?>
                <?php echo   "<a href='?do=Edit&id=" .$mrow['id']. "'><button class='btn btn-info confirm'>add reply </button></a>"; ?>
              </td>
              <td><?php echo strip_tags($mrow['comment'])?></td>
              <td class="sname"><?php echo $mrow['user_name']?></td>
            </tbody>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
  <?php
}elseif($do == 'Edit'){
    $fid  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $id =filter_var(strip_tags($fid), FILTER_SANITIZE_NUMBER_INT	);

  $stmtE = $con->prepare("SELECT * FROM comments WHERE id= ?");
  $stmtE->execute(array($id));
  $mans = $stmtE->fetch();
  $countE = $stmtE->rowCount();
  if($countE > 0){
  ?>
  <div class=" add-sec all-c">
    <div class="container">
      <h1 class="text-right">reply </h1>
      <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="id" value="<?php echo $id ?>" />
        <div class="form-group">
          <div class="col-sm-10 col-md-6 pull-right">
            <input  type="text" name="comment_reply" class="form-control" autocomplete="off"
              required="required" value="<?php echo $mans['comment_reply']; ?>"/>
          </div>
        </div>
        <div class="col-sm-10 col-md-6 pull-right">
          <input type="submit" class="btn btn-info" value="save"  />
        </div>
      </form>
    </div>
    </div>
  <?php
  }else{
    $theMsg =  '';
    redirectTo($theMsg, 'comments.php', 0);
  }
}elseif($do == 'Update'){
  echo "<div class='container'>";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $id = filter_var(strip_tags($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
      $commentreply = filter_var(strip_tags($_POST['comment_reply']), FILTER_SANITIZE_STRING);

      $stmt  = $con->prepare("UPDATE
                                comments
                              SET
                              comment_reply =?
                              WHERE
                                id = ?  ");
      $stmt->execute(array($commentreply, $id));
      $theMsg =  '<div class="btn btn-success">the reply is added   </div>';
      redirectTo($theMsg, 'comments.php');
    }else{
      $theMsg =  '';
      redirectTo($theMsg, 'comments.php');
    }
  echo "</div>";
}elseif($do == 'Delete'){
    $id  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    $secid =filter_var(strip_tags($id), FILTER_SANITIZE_NUMBER_INT	);

?>
<div class="all-c users">
  <div class="container">
    <?php
      $udstmt = $con->prepare("SELECT * FROM comments WHERE id = ?");
      $udstmt->execute(array($secid));
      $count = $udstmt->rowCount();
      if($count > 0){
        $udastmt = $con->prepare("DELETE FROM comments WHERE id = ? LIMIT 1");
        $udastmt->execute(array($secid));
        $theMsg =  '<div class="btn btn-success">the comment is deleted.   </div>';
        redirectTo($theMsg, 'comments.php');
      }else{
        $theMsg =  '';
        redirectTo($theMsg, 'comments.php', 0);
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
    ob_end_flush(); // Release the output
  ?>
