<?php
  ob_start();
  session_start();
  $pageTitle = 'categories';
  if(isset($_SESSION['email'])) {
    include 'init.php';

    $fdo = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    $do =  filter_var(strip_tags($fdo), FILTER_SANITIZE_STRING);

    if($do == 'Manage'){
      $stmtM = $con->prepare("SELECT * FROM categories");
      $stmtM->execute();
      $mans = $stmtM->fetchAll();
      ?>
      <div class="users ">
        <div class="container">
          <h2 class="text-center sections-header"> categories page</h2>
          <div class="users-table sections-table">
            <table>
              <thead>
                <tr>

                  <td>control</td>
                  <td>comments</td>
                  <td>likes</td>
                  <td>views</td>
                  <td>articles</td>
                  <td>name</td>
                </tr>
              </thead>
              <?php
              foreach($mans as $man){
              ?>
              <tbody>
                 <td>
                  <button class="btn btn-danger"><a href="?do=Delete&id=<?php echo $man['id']; ?>">Delete</a></button>
                  <button class="btn btn-info"> <a href="?do=Edit&id=<?php echo $man['id']; ?>"> Edit</a></button>
                </td>
                <td><?php echo countColumn('comment', 'comments', 'cat_id', $man['id']); ?> </td>
                <td><?php echo countColumn('likeit', 'likes', 'cat_id', $man['id']); ?></td>
                <td><?php echo countColumn('viewit', 'views', 'cat_id', $man['id']); ?></td>
                <td><?php echo countColumn('name', 'items', 'cat_id', $man['id']); ?></td>
                <td>
                  <a class="sname" href="items.php"><?php echo htmlspecialchars($man['name']);?></a>
                </td>
              </tbody>
              <?php } ?>
            </table>
            <a href="?do=Add" class="btn user-btn">Add new </a>
          </div>
        </div>
      </div>
      <?php
    }elseif($do == 'Add'){
      ?>
      <div class=" add-sec all-c">
        <div class="container">
          <h1 class="text-right">add new category</h1>
          <form class="form-horizontal" action="?do=Insert" method="POST">
            <div class="form-group">
              <div class="col-sm-10 col-md-6 pull-right">
                <input  type="text" name="name" class="form-control" autocomplete="off"
                  required="required"  placeholder="category's name "/>
              </div>
            </div>
            <div class="col-sm-10 col-md-6 pull-right">
              <input type="submit" class="btn btn-info" value="save"  />
            </div>
          </form>
        </div>
        </div>
      <?php
    }elseif($do == 'Insert'){
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $check =  checkItemsExist('name', 'categories', $name);
        ?>
        <div class=" add-sec all-c">
          <div class="container">
            <?php
            if($check == 1) {
              $theMsg =  '<div class="btn btn-danger">there is a category with this name, choose another name. </div>';
              redirectTo($theMsg, 'categories.php');
            }else{
              $stmt = $con->prepare("INSERT INTO categories(name) VALUES(:zname)");
              $stmt->execute(array(
                'zname'  => $name
              ));
              $theMsg =  '<div class="btn btn-success">the category is added </div>';
              redirectTo($theMsg, 'categories.php');
            }
            ?>
          </div>
        </div>
            <?php
      }else{
        $theMsg =  '';
        redirectTo($theMsg, 'index.php');
      }
    }elseif($do == 'Edit'){
      $fid  = isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
      $id =filter_var(strip_tags($fid), FILTER_SANITIZE_NUMBER_INT	);

      $stmtE = $con->prepare("SELECT * FROM categories WHERE id= ?");
      $stmtE->execute(array($id));
      $mans = $stmtE->fetch();
      $countE = $stmtE->rowCount();
      if($countE > 0){
      ?>
      <div class=" add-sec all-c">
        <div class="container">
          <h1 class="text-right">Edit the category</h1>
          <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <div class="form-group">
              <div class="col-sm-10 col-md-6 pull-right">
                <input  type="text" name="name" class="form-control" autocomplete="off"
                  required="required" value="<?php echo $mans['name']; ?>"/>
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
        $theMsg =  '<div class="btn btn-success">there is no category with this name </div>';
        redirectTo($theMsg, 'categories.php, 5');
      }
    }elseif($do == 'Update'){
      echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $id = $_POST['id'];
          $name = $_POST['name'];

          $stmt  = $con->prepare("UPDATE
                                    categories
                                  SET
                                  name =?
                                  WHERE
                                    id = ?  ");
          $stmt->execute(array($name, $id));
          $theMsg =  '<div class="btn btn-success">the category is updated </div>';
          redirectTo($theMsg, 'categories.php');
        }else{
          $theMsg =  '';
          redirectTo($theMsg, 'categories.php'. 1);
        }
      echo "</div>";
    }elseif($do == 'Delete'){
        $id  = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        $secid =filter_var(strip_tags($id), FILTER_SANITIZE_NUMBER_INT	);

    ?>
    <div class="all-c users">
      <div class="container">
        <?php
          $udstmt = $con->prepare("SELECT * FROM categories WHERE id = ?");
          $udstmt->execute(array($secid));
          $count = $udstmt->rowCount();
          if($count > 0){
            $udastmt = $con->prepare("DELETE FROM categories WHERE id = ? LIMIT 1");
            $udastmt->execute(array($secid));
            $theMsg =  '<div class="alert alert-success">the category is deleted.</div>';
            redirectTo($theMsg, 'categories.php');
          }else{
            $theMsg =  '';
            redirectTo($theMsg, 'categories.php', 0);
          }
    }else{
      $theMsg =  '';
      redirectTo($theMsg, 'dashboard.php');
    }
    ?>
    </div>
    </div>

<?php include $temps . 'footer.php';
  }else{
    header('Location:index.php');
    exit();
  }
  ob_end_flush();
?>
